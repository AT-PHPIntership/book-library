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
     * @param Request $request request
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

        $books = Book::select($columns);
        $conditions = [];
        if ($request->name && $request->author) {
            $books = Book::where('name', 'like', '%' . $request->name . '%')
            ->Orwhere('author', 'like', '%' . $request->author . '%');
        } else {
            if ($request->name) {
                $conditions[] = ['name', 'like', '%' . $request->name . '%'];
            }
            if ($request->author) {
                $conditions[] = ['author', 'like', '%' . $request->author . '%'];
            }
        }
        $books = Book::select($columns)->where($conditions)->with('borrowings')->withCount('borrowings')
        ->sortable()
        ->paginate(config('define.page_length'));

        return view('backend.books.list', compact('books'));
    }
}
