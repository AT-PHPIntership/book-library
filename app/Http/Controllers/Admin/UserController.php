<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\User;

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
            'users.team',
            'users.role',
            DB::raw('COUNT(DISTINCT(borrowings.id)) AS total_borrowed'),
            DB::raw('COUNT(DISTINCT(donators.id)) AS total_donated'),
        ];
        // Virtual session
        $virtualsession = User::select()->where('id', 4)->first();
        
        $users = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->select($fields)
        ->groupBy('users.id')
        ->paginate(config('define.page_length'));
        return view('backend.users.index', compact('users', 'virtualsession'));
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
