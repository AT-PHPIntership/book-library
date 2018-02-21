<?php

namespace App\Http\Controllers\Api;

use App\Model\Book;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;

class BookController extends ApiController
{
    /**
     * Get list of books
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'id',
            'name',
            'image',
            'avg_rating'
        ];
        $books = Book::select($fields)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        return $this->showAll($books);
    }
}
