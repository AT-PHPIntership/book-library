<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Symfony\Component\HttpFoundation\Response;

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
            ->orderBy('id', 'desc')
            ->paginate(config('define.page_length'));
        return metaResponse($categories);
    }
}
