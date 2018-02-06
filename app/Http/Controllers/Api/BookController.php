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
        $timeDelete = Book::withTrashed()->select('deleted_at')->find($id);
        DB::beginTransaction();
        try {
            //Restore book and favorites of its.
            $book = Book::withTrashed()->find($id)->restore();
            Favorite::withTrashed()->where('deleted_at', $timeDelete->deleted_at)->where('favoritable_type', Favorite::TYPE_BOOK)->where('favoritable_id', $id)->restore();

            //Restore rating, qrcode, borrowing.
            Rating::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            QrCode::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            Borrowing::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();

            //Restore post. Get list post was restored. Restored all comment and favorites for each post.
            $posts = Post::withTrashed()->select('id')->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->get();
            Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            foreach ($posts as $post) {
                //Restore favorites of each post.
                Favorite::withTrashed()->where('deleted_at', $timeDelete->deleted_at)->where('favoritable_type', Favorite::TYPE_POST)->where('favoritable_id', $post->id)->restore();

                //Get list comment for each post.
                $comments = Comment::withTrashed()->where('post_id', $post->id)->where('deleted_at', $timeDelete->deleted_at)->get();

                //Restore all comment for each post.
                Comment::withTrashed()->where('post_id', $post->id)->where('deleted_at', $timeDelete->deleted_at)->restore();

                //Restore favorites for each comment.
                foreach ($comments as $comment) {
                    Favorite::withTrashed()->where('deleted_at', $timeDelete->deleted_at)->where('favoritable_type', Favorite::TYPE_COMMENT)->where('favoritable_id', $comment->id)->restore();
                }
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
        }
        if ($request->ajax()) {
            return response()->json(['book'=> $book], 200);
        }
    }
}
