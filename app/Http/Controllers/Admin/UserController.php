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
   * @param string $employeeCode employeeCode of user
   *
   * @return \Illuminate\Http\Response
   */
    public function show($employeeCode)
    {
        $field = [
            'users.employee_code',
            'users.name',
            'users.email',
            'users.role',
            'users.created_at',
            'users.avatar_url',
            DB::raw('count(distinct(borrowings.id)) as sum_borrowed'),
            DB::raw('count(distinct(donators.id)) as sum_donated'),
            DB::raw('count(distinct(ratings.id)) as sum_ratings'),
        ];
        $user = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->leftJoin('ratings', 'ratings.user_id', '=', 'users.id')
        ->select($field)
        ->groupBy('users.id');
        return view('backend.users.shows', compact('user'));
    }
}
