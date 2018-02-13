<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Category;

class CategoryController extends Controller
{
    /**
     * Response api list categories, its paginate and success is true.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name')
            ->withCount('books')
            ->groupBy('id')
            ->paginate(config('define.page_length'));
        $categories = collect(['success' => true])->merge($categories);
        return response()->json($categories);
    }
}
