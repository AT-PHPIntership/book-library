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
        $fields = [
            'users.id',
            'users.employee_code',
            'users.name',
            'users.email',
            DB::raw('COUNT(DISTINCT(borrowings.id)) AS total_borrowed'),
            DB::raw('COUNT(DISTINCT(donators.id)) AS total_donated'),
        ];
        $users = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->select($fields)
        ->groupBy('users.id')
        ->paginate(config('define.page_length'));
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
          'users.employee_Code',
          'users.name',
          'users.email',
          'users.role',
          'users.created_at',
          'users.avatar_url',
          DB::raw('count(distinct(borrowings.id)) as total_borrowed'),
          DB::raw('count(distinct(ratings.id)) as total_ratings'),
          DB::raw('count(distinct(donators.id)) as total_donated'),
        ];

        $user = DB::table('users')
        ->leftJoin('borrowings', 'users.id', '=', 'borrowings.user_id')
        ->leftJoin('ratings', 'users.id', '=', 'ratings.user_id')
        ->leftJoin('donators', 'users.id', '=', 'donators.user_id')
        ->select($field)
        ->where('users.employee_Code', '=', $employeeCode)
        ->groupBy('users.id')
        ->first();

        $borrowing = DB::table('borrowings')
        ->Join('books', 'borrowings.book_id', '=', 'books.id')
        ->Join('users', 'borrowings.user_id', '=', 'users.id')
        ->select('books.name')
        ->where('users.employee_Code', '=', $employeeCode)
        ->whereNull('borrowings.to_date')
        ->first();
        return view('backend.users.show', compact('user', 'borrowing'));
    }
}
