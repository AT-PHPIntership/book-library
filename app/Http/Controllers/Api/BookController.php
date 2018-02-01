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
            Rating::where('book_id', $id)->delete();
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
        $listPostID = Post::select('id')->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->get();

        DB::beginTransaction();
        try {
            $book = Book::withTrashed()->find($id)->restore();
            Borrowing::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            Post::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            QrCode::withTrashed()->where('book_id', $id)->where('deleted_at', $timeDelete->deleted_at)->restore();
            foreach ($listPostID as $postID) {
                Comment::where('post_id', $postID->id)->where('deleted_at', $timeDelete->deleted_at)->update(['deleted_at' => null]);
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
