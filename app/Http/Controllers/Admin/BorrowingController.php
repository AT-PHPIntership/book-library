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
        $fields = [
            'users.employee_code',
            'users.name',
            'users.email',
            'books.name',
            'borrowings.from_date',
            'borrowings.to_date',
        ];
        $borrowings = Borrowing::Join('users', 'users.id', '=', 'borrowings.user_id')
            ->Join('books', 'books.id', '=', 'borrowings.book_id')
            ->select($fields)
            ->paginate(config('define.page_length'));
        return view('backend.books.borrow', compact('borrowings'));
    }
}
