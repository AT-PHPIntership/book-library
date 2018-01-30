<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Model\User;
use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of User.
     *
     *@param Request $request request
     *
     * @return mixed
     */
    public function index(Request $request)
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
        $users = User::select($fields)
                    ->leftJoin('borrowings', 'borrowings.user_id', '=', 'users.id')
                    ->groupBy('users.id')
                    ->leftJoin('donators', 'donators.user_id', '=', 'users.id')
                    ->leftJoin('books', 'donators.id', 'books.donator_id');
        // get value filter and limit on url
        $filter = $request->input('filter');
        $limit = $request->input('limit');
        if ($filter == Book::DONATED) {
            $users = $users->orderby('total_donated', 'DESC')
                            ->limit($limit)
                            ->get();
        } else {
            $users = $users->paginate(config('define.page_length'));
        }
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
            DB::raw('count(distinct(borrowings.book_id)) as total_borrowed'),
            DB::raw('count(distinct(donators.id)) as total_donated')
        ];

        $user = User::select($fields)
        ->leftJoin('borrowings', 'users.id', '=', 'borrowings.user_id')
        ->leftJoin('donators', 'users.id', '=', 'donators.user_id')
        ->where('users.employee_Code', '=', $employeeCode)
        ->groupBy('users.id')
        ->firstOrFail();

        $bookBorrowing = DB::table('borrowings')
        ->join('books', 'borrowings.book_id', '=', 'books.id')
        ->join('users', 'borrowings.user_id', '=', 'users.id')
        ->select('books.name')
        ->where('users.employee_Code', '=', $employeeCode)
        ->whereNull('borrowings.to_date')
        ->first();

        return view('backend.users.show', compact('user', 'bookBorrowing'));
    }
}
