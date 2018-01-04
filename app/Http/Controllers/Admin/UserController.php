<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;
use DB;

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
   * Display detail of user.
   *
   * @param int $id user id
   *
   * @return \Illuminate\Http\Response
   */
    public function show($id)
    {
        $user = DB::table('users')->where('employee_code', $id)->first();
        return view('backend.users.details', compact('user'));
    }
}
