<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Book;
use App\Model\Post;
use App\Model\Borrowing;
use App\Model\QrCode;
use App\Model\Rating;
use App\Model\Comment;
use App\Model\Favorite;

class BookController extends Controller
{
    /**
     * Soft delete "book" and its relationship ("borrowing", "post", "qrcode", "comment"),
     * Hard delete "rating" with id of book.
     *
     * @param Request $request request
     * @param int     $id      id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $book = Book::find($id)->delete();
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
        }
        if ($request->ajax()) {
            return response()->json(['book'=> $book], 200);
        }
    }

    /**
     * Restore book and its relationship with id of book.
     *
     * @param Request $request request
     * @param int     $id      id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $timeDelete = Book::withTrashed()->where('id', $id)->pluck('deleted_at')->first();
        DB::beginTransaction();
        try {
            //Restore book and its favorite.
            $book = Book::withTrashed()->find($id)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete)->where('favoritable_type', Favorite::TYPE_BOOK)->where('favoritable_id', $id)->restore();

            //Restore rating, qrcode, borrowing.
            Rating::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->restore();
            QrCode::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->restore();
            Borrowing::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->restore();

            //Get all posts was restored.
            $posts = Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->pluck('id')->toArray();

            //Restore all post of this book and its favorite.
            Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete)->where('favoritable_type', Favorite::TYPE_POST)->whereIn('favoritable_id', $posts)->restore();

            //Get all comments of posts was restored.
            $comments = Comment::withTrashed()->where('deleted_at', $timeDelete)->whereIn('post_id', $posts)->pluck('id')->toArray();

            //Restore all comments and its favorite.
            Comment::withTrashed()->whereIn('post_id', $posts)->where('deleted_at', $timeDelete)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete)->where('favoritable_type', Favorite::TYPE_COMMENT)->whereIn('favoritable_id', $comments)->restore();
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
        }
        if ($request->ajax()) {
            return response()->json(['book'=> $book], 200);
        }
    }
}
