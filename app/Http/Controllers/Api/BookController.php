<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Exception;
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
     * The Book implementation.
     *
     * @var Book
     */
    protected $book;
    /**
     * Create a new controller instance.
     *
     * @param Book $book instance of Book
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }
    /**
     * Display the specified resource.
     *
     * @param int $id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fields = [
            'name',
            'author',
            'year',
            'page_number',
            'price',
            'image',
            'description',
            'avg_rating'
        ];
        $books = $this->book->select($fields)->findOrFail($id);
        
        return response()->json([
            "meta" => [
                "status" => "successfully",
                "code" => 200
            ],
            "data" => $books
            ], Response::HTTP_OK);
    }
    
    /**
     * Soft delete "book" and its relationship ("borrowing", "post", "qrcode", "comment"),
     * Hard delete "rating" with id of book.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedTime = Carbon::now();

        //Get list post ids.
        $postsID = Post::where('book_id', $id)->pluck('id')->toArray();

        //Get all comments ID of posts was deleted.
        $commentsID = Comment::whereIn('post_id', $postsID)->pluck('id')->toArray();
        DB::beginTransaction();
        try {
            //Delete book and its favorite.
            $deleted = Book::where('id', $id)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            if ($deleted === 0) {
                $message = __('book.notification.book_not_found');
                return response()->json(['message'=> $message], Response::HTTP_OK);
            }
            Favorite::where('favoritable_id', $id)->where('favoritable_type', Favorite::TYPE_BOOK)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);

            //Delete rating, qrcode, borrowing, post.
            Rating::where('book_id', $id)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            QrCode::where('book_id', $id)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            Borrowing::where('book_id', $id)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            
            //Delete posts and its favorites.
            Post::where('book_id', $id)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            Favorite::whereIn('favoritable_id', $postsID)->where('favoritable_type', Favorite::TYPE_POST)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            
            //Delete all comments and its favorites.
            Comment::whereIn('post_id', $postsID)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            Favorite::whereIn('favoritable_id', $commentsID)->where('favoritable_type', Favorite::TYPE_COMMENT)->update(['deleted_at' => $deletedTime, 'updated_at' => $deletedTime]);
            DB::commit();
            $message = __('book.notification.success');
            return response()->json(['message'=> $message], Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = __('book.notification.sql');
            return response()->json(['message'=> $message], Response::HTTP_OK);
        }
    }

    /**
     * Restore book and its relationship with id of book.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $deletedTime = Book::withTrashed()->where('id', $id)->pluck('deleted_at')->first();

        DB::beginTransaction();
        //Get all posts ID was restored and its comments ID.
        $postsID = Post::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->pluck('id')->toArray();
        $commentsID = Comment::withTrashed()->where('deleted_at', $deletedTime)->whereIn('post_id', $postsID)->pluck('id')->toArray();
        try {
            //Restore book and its favorite.
            $restored = Book::withTrashed()->whereNotNull('deleted_at')->where('id', $id)->restore();
            if ($restored === 0) {
                $message = __('book.notification.book_not_found');
                return response()->json(['message'=> $message], Response::HTTP_OK);
            }
            Favorite::withTrashed()->where('deleted_at', $deletedTime)->where('favoritable_type', Favorite::TYPE_BOOK)->where('favoritable_id', $id)->restore();

            //Restore rating, qrcode, borrowing.
            Rating::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->restore();
            QrCode::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->restore();
            Borrowing::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->restore();

            //Restore all post of this book and its favorite.
            Post::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->restore();
            Favorite::withTrashed()->where('deleted_at', $deletedTime)->where('favoritable_type', Favorite::TYPE_POST)->whereIn('favoritable_id', $postsID)->restore();

            //Restore all comments and its favorite.
            Comment::withTrashed()->whereIn('post_id', $postsID)->where('deleted_at', $deletedTime)->restore();
            Favorite::withTrashed()->where('deleted_at', $deletedTime)->where('favoritable_type', Favorite::TYPE_COMMENT)->whereIn('favoritable_id', $commentsID)->restore();
            DB::commit();
            $message = __('book.notification.success');
            return response()->json(['message'=> $message], Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = __('book.notification.sql');
            return response()->json(['message'=> $message], Response::HTTP_OK);
        }
    }
}
