<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return mixed
     */
    public function index()
    {
        return view('backend.users.index');
    }

    /**
     * Display User Detail.
     *
     * @return mixed
     */
    public function show()
    {
        return view('backend.users.show');
    }
}
