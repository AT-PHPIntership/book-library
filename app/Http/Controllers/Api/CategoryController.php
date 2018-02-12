<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Model\Book;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Response;
use App\Libraries\Traits\ApiTrait;

class CategoryController extends ApiController
{
    use ApiTrait;

    /**
     * Response api list categories, its paginate and meta.
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
        if (sizeof($categories['data']) === 0) {
            return response()->json($this->fail(Response::HTTP_NOT_FOUND));
        }
        $apiCategories = $this->convertPaginateApi($categories);
        return response()->json($this->success($apiCategories, Response::HTTP_OK));
    }
}
