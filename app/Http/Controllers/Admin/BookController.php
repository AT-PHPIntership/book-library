<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Book;
use App\Model\User;
use App\Model\Donator;
use App\Http\Requests\BookEditRequest;
use File;

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
     * Display list book.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.layouts.books.list');
    }

    /**
     * Show the form for edit book.
     *
     * @param int $id book
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryFields = [
            'id',
            'name'
        ];
        $book = Book::findOrFail($id);
        $categories = Category::select($categoryFields)->get();
        return view('backend.books.edit', compact('book', 'categories'));
    }

    public function update(BookEditRequest $request, $id) {
        $book = Book::findOrFail($id);
        // save image path, move image to directory
        if (isset($request->image)) {
            $oldPath = $book->image;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $image = $request->image;
            $name = config('image.name_prefix') . "-" . $image->hashName();
            $folder = config('image.books.path_upload');
            $image->move($folder, $name);

            $newPath = $folder . $name;
            $book->image = $newPath;
        }

        //save new donator
        $user = User::where('employee_code', $request->employee_code)->first();
        if (empty($user)) {
            $donatorData = [
                'employee_code' => $request->employee_code,
            ];
        } else {
            $donatorData = [
                'user_id' => $user->id,
                'employee_code' => $user->employee_code,
                'email' => $user->email,
                'name' => $user->name,
            ];
        }
        $donator = Donator::updateOrCreate(['employee_code' => $request->employee_code], $donatorData);
        $book->donator_id = $donator->id;

        $book->name = $request->name;
        $book->author = $request->author;
        $book->category_id = $request->category_id;
        $book->year = $request->year;
        $book->price = $request->price;
        $book->description = $request->description;

        $result = $book->save();

        //save new qrcode
        $lastestCodeId = QrCode::select('code_id')->orderby('code_id', 'desc')->first();
        if (empty($lastestCodeId)) {
            $lastestCodeId = QrCode::DEFAULT_CODE_ID;
        } else {
            $lastestCodeId = $lastestCodeId->code_id + 1;
        }
        $book->qrcode()->save(
            new QrCode([
                'prefix' => QrCode::QRCODE_PREFIX,
                'code_id'=> $lastestCodeId,
            ])
        );

        if ($result) {
            flash(__('Edit success'))->success();
            return redirect()->route('books.index');
        } else {
            flash(__('Edit failure'))->error();
            return redirect()->back()->withInput();
        }
    }
}
