<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\User;
use App\Model\Donator;
use App\Model\Brorrow;

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
            'user.id',
            'user.employee_code',
            'user.name',
            'user.email',
            DB::raw('count(distinct(borrow.id)) as total_donated'),
            DB::raw('count(distinct(donator.id)) as total_borrowed'),
        ];
        $users = User::leftJoin('borrow', 'borrow.user_id', '=', 'user.id')
        ->leftJoin('donator', 'donator.user_id', '=', 'user.id')
        ->select($field)
        ->groupBy('user.id')
        ->paginate(User::ROW_LIMIT);
        return view('backend.users.index', compact('users'));
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
