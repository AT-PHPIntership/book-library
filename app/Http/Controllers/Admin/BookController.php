<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Model\Category;
use App\Model\Book;
use App\Model\User;
use App\Model\Donator;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = [
            'id',
            'name'
        ];
        $categories = Category::select($fields)->get();
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Store a newly book created resource in storage.
     *
     * @param App\Http\Requests\BookCreateRequest $request get create request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        $book = new Book($request->toArray());
        // save image path, move image to directory
        if (isset($request->image)) {
            $image = $request->image;
            $name = config('image.name_prefix') . "-" . $image->hashName();
            $folder = config('image.books.path_upload');
            $image->move($folder, $name);

            $path = $folder . $name;
            $book->image = $path;
        } else {
            $path = config('image.no_image');
            $book->image = $path;
        }
        //save generate qrcode
        $book->QRcode = $book->generateQRcode();

        //save new donator
        $user = User::where('employee_code', $request->donator_id)->first();
        $donatorData = [
            'user_id' => $user->id,
            'employee_code' => $user->employee_code,
            'email' => $user->email,
        ];
        $donator = Donator::firstOrCreate($donatorData);
        $book->donator_id = $donator->id;
        $result = $book->save();

        if ($result) {
            flash(__('Create success'))->success();
            return redirect()->route('books.create');
        } else {
            flash(__('Create failure'))->error();
            return redirect()->back()->withInput();
        }
    }
}
