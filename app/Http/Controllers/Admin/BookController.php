<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = [
            'id',
            'name'
        ];
        $categories = Category::select($fields)->get();
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Display list book.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $searchBy  = $request->searchby;

        $columns = [
            'id',
            'name',
            'author',
            'avg_rating',
            'total_rating'
        ];

        $books = Book::select($columns);
        if ($request->has('search')  || $request->has('searchby')) {
                switch ($searchBy) {
                    case 'Author':
                        $books = $books->where('author', 'like', '%'.$search.'%')->paginate(Book::ROW_LIMIT);
                        break;
                    case 'Name':
                        $books = $books->where('name', 'like', '%'.$search.'%')->paginate(Book::ROW_LIMIT);
                        break;
                    default:
                        $books = $books->where('name', 'like', '%'.$search.'%')
                        ->orwhere('author', 'like', '%'.$search.'%')->paginate(Book::ROW_LIMIT);
                        break;
            }
        } else {
            $books = $books->paginate(Book::ROW_LIMIT);
        }
        return view('backend.books.list', compact('books'));
    }
}
