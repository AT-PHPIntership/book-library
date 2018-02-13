<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Model\Book;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Response;

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
            ->paginate(config('define.page_length'))
            ->toArray();
        $categories['success'] = true;
        return response()->json($categories);
    }
}
