<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function showDetails(){
    	return view('backend.users.details');
    }
}