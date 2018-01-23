<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    /**
     * Show the page borrowings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.books.borrow');
    }
}
