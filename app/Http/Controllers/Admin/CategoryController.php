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

    /**
     * Update the name corresponding to the category ID in the database.
     *
     * @param Illuminate\Http\Request $data data
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data)
    {
        $category = Category::findOrFail($data->id);
        $category->name = $data->name;
        $category->save();
        
        return response()->json($data);
    }
}
