<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Book;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Get top 10 most review
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTopReview()
    {
        $fields = [
            'name',
            'books.image',
            'avg_rating',
        ];
        $reviewBooks = Book::select($fields)->withCount(['posts' => function($query) {
            $query->where('type', 1);
        }])->orderBy('posts_count', 'DESC')
           ->limit(10)
           ->get();
        foreach($reviewBooks as $book) {
            $book['image'] = request()->getHttpHost(). '/' . $book['image'];
        }
        return response()->json([
            'meta' => [
                'status' => 'successfully',
                'code' => Response::HTTP_OK,
            ],
            'data' => $reviewBooks
        ], Response::HTTP_OK);
    }
}
