<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
            'number_of_pages',
            'price',
            'image',
            'description',
            'avg_rating'
        ];

        $detailsBook = Book::select($fields)->findOrFail($id);
        return metaResponse(['data' => $detailsBook]);
    }
    
    /**
     * Get top 10 most review
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopReview()
    {
        $fields = [
            'name',
            'image',
            'avg_rating',
        ];
        $reviewBooks = Book::select($fields)->withCount(['posts' => function ($query) {
            $query->where('type', Book::REVIEW_TYPE);
        }])->orderBy('posts_count', 'DESC')
           ->limit(Book::TOP_REVIEW_LIMIT)
           ->get();
        return metaResponse(['data' => $reviewBooks]);
    }
    
    /**
     * Get top borrow books with paginate and meta.
     *
     * @return \Illuminate\Http\Response
     */
    public function topBorrow()
    {
        $topBorrowed = Book::select(['name'])
            ->withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->paginate(config('define.book.item_limit'));
        return metaResponse($topBorrowed);
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
        DB::beginTransaction();
        try {
            if (Book::restore($id)) {
                DB::commit();
                $message = __('book.notification.success');
                return response()->json(['message'=> $message], Response::HTTP_OK);
            } else {
                $message = __('book.notification.book_not_found');
                return response()->json(['message'=> $message], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $message = __('book.notification.sql');
            return response()->json(['message'=> $message], Response::HTTP_OK);
        }
    }
    /**
     * Get api list books, meta and paginate
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'id',
            'name',
            'author',
            'image',
            'avg_rating'
        ];
        $books = Book::select($fields)
            ->where('name', 'like', "%$request->search%")
            ->orWhere('author', 'like', "%$request->search%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('define.book.item_limit'));
        $books->appends(['search' => $request->search])->render();
        return metaResponse($books);
    }

    /**
     * Get all book's reviews
     *
     * @param integer $id book's id
     *
     * @return Illuminate\Http\Response
     */
    public function getReviewsOfBook($id)
    {
        $dataReview = Post::getPost(['ratings.id as rating_id', 'rating'])->leftJoin('ratings', function ($join) {
                $join->on('posts.user_id', '=', 'ratings.user_id');
                $join->on('posts.book_id', '=', 'ratings.book_id');
        })->where([
                ['posts.type', Post::REVIEW_TYPE],
                ['books.id', $id],
                ['favorites.favoritable_type', Favorite::TYPE_POST]
            ])->paginate(config('define.review.limit_render'));
        return metaResponse($dataReview);
    }
}
