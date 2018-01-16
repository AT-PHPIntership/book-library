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
     * @param Request $request request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            'id',
            'name',
            'author',
            'avg_rating',
            'total_rating'
        ];
        $filter = $request->input('filter');
        $limit = $request->input('limit');
        $books = Book::select($columns);

        if ($request->name) {
            $books = $books->searchname($request->name);
        }
        if ($request->author) {
            $books = $books->searchauthor($request->author);
        }

        if ($filter == 'borrowed' && $limit == 10) {
            $books = $books->withCount('borrowings')
                    ->orderBy('borrowings_count', 'DESC')
                    ->limit($limit)
                    ->get();
        } else {
            $books = $books->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
        }
        return view('backend.books.list', compact('books'));
    }
}
