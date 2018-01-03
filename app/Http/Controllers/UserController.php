<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show detail of user.
     *
     * @return void
     */
    public function showDetails()
    {
        return view('backend.users.details');
    }
}
