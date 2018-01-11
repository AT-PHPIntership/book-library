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
        $name = $request->name;
        $author  = $request->author;

        $columns = [
            'id',
            'name',
            'author',
            'avg_rating',
            'total_rating'
        ];
        $books = Book::select($columns);
        if ($request->has('name')  || $request->has('author')) {
            if ($name && $author) {
                $books = $books->searchnameauthor($name, $author)->with('borrowings')->withCount('borrowings')
                ->sortable()
                ->paginate(config('define.page_length'));
            } else {
                if ($name) {
                    $books = $books->searchname($name)->with('borrowings')->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
                }
                if ($author) {
                    $books = $books->searchauthor($author)->with('borrowings')->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
                }
            }
            if ($name == "" && $author == "") {
                $books = $books->with('borrowings')->withCount('borrowings')
                ->sortable()
                ->paginate(config('define.page_length'));
            }
        } else {
            $books = $books->with('borrowings')->withCount('borrowings')
            ->sortable()
            ->paginate(config('define.page_length'));
        }

        return view('backend.books.list', compact('books'));
    }
}
