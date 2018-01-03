<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.books.create');
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
        
    }
}
