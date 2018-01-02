<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Book;
use App\Model\Category;
use App\Model\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use Illuminate\Http\Response;

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
            'name',
        ];
        $categories = Category::select($fields)->get();
        return view('backend.books.create')->with('categories', $categories);
    }
    
    /**
     * Save creating book
     *
     * @param App\Http\Requests\BookCreateRequest $request Request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        $book = new Book($request->toArray());
        if (!User::where('employee_code', $request->donate_by)->exists()) {
            $request->session()->flash('message', 'Employee with id ' . $request->donate_by . ' not exist');
            return redirect()->back()->withInput();
        }
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
        $result = $book->save();

        if ($result) {
            return redirect()->route('books.create');
        } else {
            return redirect()->back()->withInput();
        }
    }
}
