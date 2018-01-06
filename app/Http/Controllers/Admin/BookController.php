<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Book;

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
}
