<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Change role of user.
     *
     * @param int $id id of user
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRole($id)
    {
        $user = User::findOrFail($id);
        if ($user->team !== User::SA) {
            $newRole = 1 - $user->role;
            $user->update(['role' => $newRole]);
            $data = $newRole;
        } else {
            $data = -1;
        }
        return response()->json($data);
    }

    /**
     * Show information of User.
     *
     * @param int $id id of user
     *
     * @return mixed
     */
    public function show($id)
    {
        $fields = [
            'users.id',
            'users.employee_code',
            'users.name',
            'users.email',
            'users.team',
            'users.role',
            DB::raw('COUNT(DISTINCT(borrowings.book_id)) AS total_borrowed'),
            DB::raw('COUNT(DISTINCT(books.id)) AS total_donated'),
        ];
        
        $user = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->leftJoin('books', 'donators.id', 'books.donator_id')
        ->select($fields)
        ->groupby('users.id')
        ->findOrFail($id);
        return metaResponse(['data' => $user]);
    }
}
