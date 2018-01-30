<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\CategoryUpdateNameRequest;

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
     * @param CategoryUpdateNameRequest $data data
     *
     * @return Response
     */
    public function update(CategoryUpdateNameRequest $data)
    {
        $category = Category::findOrFail($data->id);
        $category->name = $data->name;
        $category->save();
        
        return response()->json($data);
    }
}
