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
                case 'Name':
                    $books = $books->searchName($search)
                    ->with('borrowings')->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
                    break;
                case 'Author':
                    $books = $books->searchAuthor($search)
                    ->with('borrowings')->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
                    break;
                case 'All':
                    $books = $books->SearchNameAuthor($search)
                    ->with('borrowings')->withCount('borrowings')
                    ->sortable()
                    ->paginate(config('define.page_length'));
                    break;
            }
        } else {
            $books = $books->with('borrowings')->withCount('borrowings')
            ->sortable()
            ->paginate(config('define.page_length'));
        }
        return view('backend.books.list', compact('books'));
    }
}
