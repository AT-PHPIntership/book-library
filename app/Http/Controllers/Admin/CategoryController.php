<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name')
                                ->withCount('books')
                                ->groupBy('id')
                                ->paginate(config('define.page_length'));
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Update the name corresponding to the category ID in the database.
     *
     * @param CategoryUpdateRequest $request request
     * @param int                   $id      Id of category
     *
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return response()->json($request);
    }
}
