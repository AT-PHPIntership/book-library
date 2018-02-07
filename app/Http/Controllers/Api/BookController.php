<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Book;
use Illuminate\Http\Response;

class BookController extends Controller
{

    /**
     * The Book implementation.
     *
     * @var Book
     */
    protected $book;

    /**
     * Create a new controller instance.
     *
     * @param Book $book instance of Book
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function index()
    {
        $fields = [
            'id',
            'name',
            'image',
            'avg_rating'
        ];
        $books = $this->book->select($fields)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(20);
        return response()->json([
            'books' => $books,
            'success' => true
        ], Response::HTTP_OK);
    }
}
