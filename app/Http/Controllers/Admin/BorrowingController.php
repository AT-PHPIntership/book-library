<?php

namespace App\Http\Controllers\Admin;

use App\Model\Borrowing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    /**
     * Show the page borrowings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrowings = Borrowing::with('books', 'users')
            ->sortable()
            ->orderby('from_date', 'DESC')
            ->paginate(config('define.page_length'));
        return view('backend.books.borrow', compact('borrowings'));
    }
}
