<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Book;
use DB;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'categories.id',
            'categories.name',            
            DB::raw('COUNT(books.id) AS sum_of_books'),
        ];
        
        $categories = Category::leftJoin('books', 'categories.id', 'books.category_id')
        ->select($fields)
        ->groupBy('categories.id')
        ->paginate(config('define.page_length'));
        return view('backend.categories.index', compact('categories'));
    }
}
