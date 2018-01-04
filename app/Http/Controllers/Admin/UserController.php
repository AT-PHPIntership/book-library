<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Donator;
use App\Model\Brorrow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
  /**
   * Display a listing of User.
   *
   * @return mixed
   */
    public function index()
    {
        $field = [
            'users.id',
            'users.employee_code',
            'users.name',
            'users.email',
            DB::raw('count(distinct(borrowings.id)) as total_borrowed'),
            DB::raw('count(distinct(donators.id)) as total_donated'),
        ];
        $users = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->select($field)
        ->groupBy('users.id')
        ->paginate(User::ROW_LIMIT);
        return view('backend.users.index', compact('users'));
    }

  /**
   * Display detail of user.
   *
   * @param int $id id of user
   *
   * @return \Illuminate\Http\Response
   */
    public function show($id)
    {
        $user = DB::table('users')->where('employee_code', $id)->first();
        return view('backend.users.details', compact('user'));
    }
}
