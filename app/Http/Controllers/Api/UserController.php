<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use DB;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * The Book implementation.
     *
     * @var Book
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param User $users instance of User
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this->users = $users;
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
        $data = ['data' => $user];
        return metaResponse($data);
    }
}
