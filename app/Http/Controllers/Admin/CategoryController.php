<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Model\Book;
use DB;
use Exception;
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
        $categories = Category::select('id', 'name')
                                ->withCount('books')
                                ->groupBy('id')
                                ->paginate(config('define.page_length'));
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Delete category with ajax request
     *
     * @param int $id category's id
     *
     * @return mixin
     */
    public function destroy($id, Request $request)
    {
        $page = $request->input('page');
        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $category->deleteAndSetDefault($category);
            $paginateAttr = $this->getRedirectedPage($page);
            $categories = Category::select('id', 'name')->withCount('books')
                                    ->groupBy('id')
                                    ->paginate(config('define.page_length'))
                                    ->setPath('/admin/categories');
            if ($id == Category::DEFAULT_CATEGORY) {
                throw new Exception(__('category.denied_default_delete'));
            }
            DB::commit();
            return view('backend.categories.load-category-list', compact('categories', 'paginateAttr'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 200);
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
     * @param Illuminate\Http\Request $request request
     * @param int                     $id      Id of category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return response()->json($request);
    }
}
