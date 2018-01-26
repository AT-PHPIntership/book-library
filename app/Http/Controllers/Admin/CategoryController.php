<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name')->withCount('books')
                                ->groupBy('id')
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
