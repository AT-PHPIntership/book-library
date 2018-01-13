<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use \Illuminate\Http\Request;
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

        if ($request->name) {
            $books = $books->searchname($request->name);
        }
        if ($request->author) {
            $books = $books->searchauthor($request->author);
        }

        $books = $books->withCount('borrowings')
            ->sortable()
            ->paginate(config('define.page_length'));
        return view('backend.books.list', compact('books'));
    }

    /**
     * Show the form with book data for edit book.
     *
     * @param int $book pass book object
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categoryFields = [
            'id',
            'name'
        ];
        $categories = Category::select($categoryFields)->get();
        return view('backend.books.edit', compact('book', 'categories'));
    }
}
