<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Model\Book;

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
     * Display the specified resource.
     *
     * @param int $id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fields = [
            'name',
            'author',
            'year',
            'page_number',
            'price',
            'image',
            'description',
            'avg_rating'
        ];

        $books = $this->book->select($fields)->findOrFail($id);
        
        return response()->json([
            "meta" => [
                "status" => "successfully",
                "code" => 200
            ],
            "data" => $books
            ], Response::HTTP_OK);
    }
}
