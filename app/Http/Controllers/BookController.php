<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Model\Book;

// use Illuminate\Pagination\Paginator;
class BookController extends Controller
{
    /**
    * Index
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $fields = [
            'id',
            'name',
            'author',
            'avg_rating',
        ];
        $books = Book::select($fields)->paginate(10);
        return view('backend.layouts.books.list', compact('books'));
    }

    /**
    * Search book
    *
    *  @param Request $request request
    *
    *  @return Response
    */
    public function search(Request $request)
    {
        $search = $request->search;
        $searchBy  = $request->searchBy;

        $columns = [
            'name',
            'author',
            'avg_rating',
            'total_rating'
        ];
        $books = Book::select($columns);
        switch ($searchBy) {
            case 'Author':
                $books = $books->where('author', 'like', '%'.$search.'%')->get();
                return response()->json($books);
                break;
            case 'Name':
                $books = $books->where('name', 'like', '%'.$search.'%')->get();
                return response()->json($books);
                break;
            default:
                $books = $books->where('name', 'like', '%'.$search.'%')->orwhere('author', 'like', '%'.$search.'%')->get();
                return response()->json($books);
                break;
        }
    }
}
