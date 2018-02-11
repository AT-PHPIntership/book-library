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
     * @param Request $req requests
     *
     * @return array
     */
    public function newBook(Request $req)
    {
        $fields = [
            'id',
            'name',
            'image',
            'avg_rating'
        ];
        $search = $req->get('search');
        if ($search) {
            $books = $this->book->searchs($search)->select($fields)
                                ->orderBy('created_at', 'DESC')
                                ->paginate(20);
        } else {
            $books = $this->book->select($fields)
                                ->orderBy('created_at', 'DESC')
                                ->paginate(20);
        }
        return response()->json([
            'books' => $books,
            'success' => true
        ], Response::HTTP_OK);
    }
}
