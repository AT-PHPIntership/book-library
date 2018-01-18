<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a list of Posts.
     *
     * @return mixed
     */
    public function index()
    {
        return view('backend.posts.index');
    }
}
