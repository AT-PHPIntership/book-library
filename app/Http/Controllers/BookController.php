<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Book;

class BookController extends Controller
{
    /**
    * Index
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
    	$fields = [
    		'id',
    		'name',
    		'author',
    		'avg_rating',
    	];
    	$books = Book::select($fields)->get();
        return view('backend.layouts.books.list',compact('books'));
    }
}
