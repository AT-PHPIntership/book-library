<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Book;
use App\Model\Category;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function create() {
        $column = [
            'id',
            'name',
        ];
        $categories = Category::all();
        return view('backend.books.create')->with('categories', $categories);
    }
}
