<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Book;
use App\Model\Category;
use App\Http\Controllers\Controller;

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
}
