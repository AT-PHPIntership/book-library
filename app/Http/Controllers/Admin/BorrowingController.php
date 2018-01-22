<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    public function index(){
        return view('backend.books.borrow');

    }
}
