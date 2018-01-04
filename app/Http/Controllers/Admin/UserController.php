<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

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
        //
    }
}
