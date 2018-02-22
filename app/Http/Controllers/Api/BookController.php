<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Model\Borrowing;
use Illuminate\Http\Response;
use DB;
use App\Libraries\Traits;

class BookController extends ApiController
{
    /**
     * Get list top borrow,
     *
     * @return void
     */
    public function topBorrow()
    {
        $fields = [
        'books.name',
        DB::raw('COUNT(borrowings.book_id) AS total_borrowed'),
        ];
        $topBorrowed = Borrowing::select($fields)
            ->join('books', 'books.id', '=', 'borrowings.book_id')
            ->groupBy('books.id')
            ->orderBy('total_borrowed', 'desc')
            ->get();
        return $this->showAll($topBorrowed);
    }
}
