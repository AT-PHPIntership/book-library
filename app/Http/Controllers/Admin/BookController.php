<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use DB;

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
     * Display list book with filter ( if have ).
     *
     * @param Request $request filter if have
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $uid = $request->uid;
        $filter = $request->filter;
      
        if ($request->has('uid') && $request->has('filter')) {
            if ($filter == "donated") {
                $books = Book::whereHas('donator', function ($query) use ($uid) {
                    $query->where('user_id', '=', $uid);
                })->withCount('donator')->sortable()->paginate(config('define.page_length'));
            } elseif ($filter == "borrowed") {
                $books = Book::whereHas('borrowings', function ($query) use ($uid) {
                    $query->where('user_id', '=', $uid);
                })->withCount('borrowings')->sortable()->paginate(config('define.page_length'));
            }
        } else {
            $books  = Book::with('borrowings')->withCount('borrowings')->sortable()->paginate(config('define.page_length'));
        };

        return view('backend.books.list', compact('books'));
    }
}
