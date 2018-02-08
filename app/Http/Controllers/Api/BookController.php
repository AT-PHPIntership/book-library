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
use Carbon\Carbon;

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
        $timeDelete = Carbon::now();
        DB::beginTransaction();
        try {
            //Delete book and its favorite.
            $book = Book::where('id', $id)->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            Favorite::where('favoritable_id', $id)->where('favoritable_type', Favorite::TYPE_BOOK)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);

            //Delete rating, qrcode, borrowing, post.
            Rating::where('book_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            QrCode::where('book_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            Borrowing::where('book_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);

            //Get list post ids.
            $postsID = Post::where('book_id', $id)->whereNull('deleted_at')->pluck('id')->toArray();

            //Delete posts and its favorites.
            Post::where('book_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            Favorite::whereIn('favoritable_id', $postsID)->where('favoritable_type', Favorite::TYPE_POST)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);

            //Get all comments ID of posts was deleted.
            $commentsID = Comment::whereIn('post_id', $postsID)->whereNull('deleted_at')->pluck('id')->toArray();

            //Delete all comments and its favorites.
            Comment::whereIn('post_id', $postsID)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            Favorite::whereIn('favoritable_id', $commentsID)->where('favoritable_type', Favorite::TYPE_COMMENT)->whereNull('deleted_at')->update(['deleted_at' => $timeDelete, 'updated_at' => $timeDelete]);
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
        }
        if ($request->ajax()) {
            return response()->json(['book'=> $book, 'time' => $timeDelete], 200);
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

            //Get all posts ID was restored.
            $postsID = Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->pluck('id')->toArray();

            //Restore all post of this book and its favorite.
            Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete)->where('favoritable_type', Favorite::TYPE_POST)->whereIn('favoritable_id', $postsID)->restore();

            //Get all comments ID of posts was restored.
            $commentsID = Comment::withTrashed()->where('deleted_at', $timeDelete)->whereIn('post_id', $postsID)->pluck('id')->toArray();

            //Restore all comments and its favorite.
            Comment::withTrashed()->whereIn('post_id', $postsID)->where('deleted_at', $timeDelete)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete)->where('favoritable_type', Favorite::TYPE_COMMENT)->whereIn('favoritable_id', $commentsID)->restore();
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
        }
        if ($request->ajax()) {
            return response()->json(['book'=> $book], 200);
        }
    }
}
