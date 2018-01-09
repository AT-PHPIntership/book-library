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
        
        // Virtual Session
        session(['team'=> 'SA']);

        $users = User::leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
        ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
        ->select($fields)
        ->groupBy('users.id')
        ->paginate(config('define.page_length'));
        return view('backend.users.index', compact('users'));
    }

    /**
     * Display User Detail.
     *
     * @param string $employeeCode employeeCode of user
     *
     * @return mixed
     */
    public function show($employeeCode)
    {
        $fields = [
            'users.*',
            DB::raw('count(distinct(borrowings.id)) as total_borrowed'),
            DB::raw('count(distinct(donators.id)) as total_donated')
        ];

        $user = User::select($fields)
        ->leftJoin('borrowings', 'users.id', '=', 'borrowings.user_id')
        ->leftJoin('donators', 'users.id', '=', 'donators.user_id')
        ->where('users.employee_Code', '=', $employeeCode)
        ->groupBy('users.id')
        ->first();

        $bookBorrowing = DB::table('borrowings')
        ->join('books', 'borrowings.book_id', '=', 'books.id')
        ->join('users', 'borrowings.user_id', '=', 'users.id')
        ->select('books.name')
        ->where('users.employee_Code', '=', $employeeCode)
        ->whereNull('borrowings.to_date')
        ->first();

        return view('backend.users.show', compact('user', 'bookBorrowing'));
    }

    /**
     * Change role of user when click button.
     *
     * @param Id $id Id of user changed
     *
     * @return mixed
     */
    public function changerole($id)
    {
        // Get old role of user
        $getrole = User::select('role', 'name')->where('id', $id)->first();

        // Update new role for user
        $newrole = 1 - $getrole->role;
        User::where('id', $id)->update(array('role' => $newrole));

        // Session Flash
        if ($newrole) {
            session()->flash('notification', 'You have just change the role of <b>'. $getrole->name. '</b> from <b>User</b> to <b>Admin</b>');
        } else {
            session()->flash('notification', 'You have just change the role of <b>'. $getrole->name. '</b> from <b>Admin</b> to <b>User</b>');
        }
        return redirect()->back();
    }
}
