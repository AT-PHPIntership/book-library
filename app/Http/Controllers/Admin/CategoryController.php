<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Model\Book;
use DB;
use Exception;

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
     * Delete category with ajax request
     *
     * @param int $id category's id
     *
     * @return mixin
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->deleteAndSetDefault($id);
            $paginateAttr = $this->redirectCurrentPage(\Request::get('page'));
            $url = $paginateAttr['url'];
            $page = $paginateAttr['page'];
            $categories = Category::select('id', 'name')->withCount('books')
                                    ->groupBy('id')
                                    ->paginate(config('define.page_length'))
                                    ->setPath('/admin/categories');
            $totalCategories = getCount(Category::class);
            if ($id == Category::DEFAULT_CATEGORY) {
                throw new Exception(__('category.denied_default_delete'));
            }
            DB::commit();
            return view('backend.categories.unload', compact('categories', 'url', 'page', 'totalCategories'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 200);
        }
    }

    /**
     * Delete category and set book's category_id to default
     *
     * @param int $categoryId category's id
     *
     * @return void
     */
    public function deleteAndSetDefault($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Book::where('category_id', $categoryId)->update(['category_id' => Category::DEFAULT_CATEGORY]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $category->delete();
    }

    /**
     * Redirect to page after delete success categories
     *
     * @param int $page current page
     *
     * @return array
     */
    public function redirectCurrentPage($page)
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
        $url = "/admin/categories?page=" . $page;
        return [
            'url' => $url,
            'page'=> $page
        ];
    }
}
