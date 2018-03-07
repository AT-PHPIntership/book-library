<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use App\Model\Book;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
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
     * Delete category with ajax request
     *
     * @param int                     $id      category's id
     * @param Illuminate\Http\Request $request get request
     *
     * @return mixin
     */
    public function destroy($id, Request $request)
    {
        $page = $request->input('page');
        DB::beginTransaction();
        try {
            if ($id == Category::DEFAULT_CATEGORY) {
                return response()->json(['message' => __('category.denied_default_delete')], Response::HTTP_OK);
            }
            $category = Category::find($id);
            if (empty($category)) {
                return response()->json(['message' => __('category.not_found_category')], Response::HTTP_OK);
            }
            $category->deleteAndSetDefault($category);
            $paginateAttr = $this->getRedirectedPage($page);
            $categories = Category::select('id', 'name')
                ->withCount('books')
                ->groupBy('id')
                ->paginate(config('define.page_length'))
                ->setPath('/admin/categories');
            DB::commit();
            return view('backend.categories.load-category-list', compact('categories', 'paginateAttr'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_OK);
        }
    }

    /**
     * Redirect to page after delete success categories
     *
     * @param int $page current page
     *
     * @return array
     */
    public function getRedirectedPage($page)
    {
        $rowCount = Category::count();
        $lastPageRemainRow = $rowCount % config('define.page_length');
        $currentTotalPage = ceil($rowCount / config('define.page_length'));
        if (($currentTotalPage + 1) == $page && $lastPageRemainRow == 0) {
            $page = $page - 1;
        }
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $uri = "/admin/categories?page=" . $page;
        return [
            'uri' => $uri,
            'page'=> $page
        ];
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
