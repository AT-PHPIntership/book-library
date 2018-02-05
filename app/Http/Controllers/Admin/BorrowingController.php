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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        \DB::enableQueryLog();
        $search = $request->search;
        $choose = $request->choose;
        $borrowings = Borrowing::selectRaw(DB::raw('users.employee_code, users.name, users.email, books.name as bookname,
            borrowings.from_date, borrowings.to_date'));
        if ($request->has('search') && $request->has('choose')) {
            $search = $request->search;
            $choose = $request->choose;
            $borrowings = $borrowings->search($search, $choose);
        }
        $borrowings = $borrowings->sortable()->orderby('from_date', 'DESC')->paginate(config('define.page_length'));
        return view('backend.books.borrow', compact('borrowings'));
    }
}
