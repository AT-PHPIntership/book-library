<?php

namespace App\Http\Controllers\Admin;

use App\Model\Borrowing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BorrowingController extends Controller
{
    /**
     * Show the page borrowings.
     *
     * @param Illuminate\Http\Request $request get request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [
            'borrowings.id',
            'users.employee_code',
            'users.name as user_name',
            'users.email',
            'books.name as book_name',
            'borrowings.from_date',
            'borrowings.to_date',
            'borrowings.date_send_email',
        ];
        $borrowings = Borrowing::select($filters)
            ->leftJoin('users', 'borrowings.user_id', 'users.id')
            ->leftJoin('books', 'borrowings.book_id', 'books.id');
        if ($request->has('search') && $request->has('choose')) {
            $search = $request->search;
            $choose = $request->choose;
            $borrowings = $borrowings->search($search, $choose);
        }
        $borrowings = $borrowings->sortable()->orderby('borrowings.id', 'DESC')->paginate(config('define.page_length'));
        return view('backend.books.borrow', compact('borrowings'));
    }
}
