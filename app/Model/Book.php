<?php

namespace App\Model;

use App\Model\User;
use App\Model\Rating;
use App\Model\QrCode;
use App\Model\Donator;
use App\Model\Borrowing;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use App\Libraries\Traits\SearchTrait;
use App\Model\Comment;
use App\Model\Favorite;

class Book extends Model
{
    use Sortable, SoftDeletes, CascadeSoftDeletes, SearchTrait;

    /**
     * Soft Delete Relationship
     */
    protected $cascadeDeletes = ['borrowings', 'qrcode', 'ratings', 'favorites', 'posts'];

    /**
     * Default value of category
     */
    const DEFAULT_CATEGORY = 1;

    /**
     * Top review book limit
     */
    const TOP_REVIEW_LIMIT = 10;

    /**
     * Review type
     */
    const REVIEW_TYPE = 1;

    /**
     * Default value of filter type books is donated books
     */
    const DONATED = 'donated';

    /**
     * Default value of filter type books is borrowed books
     */
    const BORROWED = 'borrowed';

    /**
     * Default value of price
     */
    const DEFAULT_PRICE = null;

    /**
     * Default author
     */
    const DEFAULT_AUTHOR = null;

    /**
     * Default pages
     */
    const DEFAULT_PAGES = null;

    /**
     * Default description
     */
    const DEFAULT_DESCRIPTION = null;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'author',
        'year',
        'price',
        'description',
        'language',
        'pages',
        'donator_id',
        'avg_rating',
        'total_rating',
        'image',
        'status',
        'number_of_pages'
    ];

    /**
     * Relationship morphMany with Favorite
     * Declare table sort
     *
     * @var array $sortable table sort
     */
    protected $sortable = ['id', 'name', 'author', 'avg_rating'];

    /**
     * Filter for search trait
     *
     * @var array $searchable table search
     */
    protected $searchable = [
        'name',
        'author'
    ];

    /**
     * Declare table sort
     *
     * @var string $sortableAs
     */
    protected $sortableAs = ['borrowings_count'];

    /**
     * Relationship morphMany with Post
     *
     * @return array
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Relationship belongsToMany with User
     *
     * @return array
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relationship belongsTo with Category
     *
     * @return array
    */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship belongsTo with Donator
     *
     * @return array
    */
    public function donator()
    {
        return $this->belongsTo(Donator::class, 'donator_id');
    }

    /**
     * Relationship hasMany with Rating
     *
     * @return array
    */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relationship hasMany with Borrowing
     *
     * @return array
    */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Relationship hasMany with Post
     *
     * @return array
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relationship hasOne with Book
     *
     * @return array
    */
    public function qrcode()
    {
        return $this->hasOne(QrCode::class);
    }

    /**
     * Upload image
     *
     * @param App\Http\Requests\BookEditRequest $request request
     *
     * @return String
     */
    public function uploadImage($request)
    {
        $folder = config('image.books.upload_path');
        $path = Storage::disk('public')->putFile($folder, $request->file('image'));
        return $path;
    }

    /**
     * Get image attribute's value
     *
     * @param string $image image string
     *
     * @return string
     */
    public function getImageAttribute($image)
    {
        $defaultPath = config('image.books.default_path');
        $defaultImage = config('image.books.no_image_name');
        $isNotDefaultImage = ($image != ($defaultPath . $defaultImage)) ? true : false;
        $fullImage = asset($image);
        if ($isNotDefaultImage) {
            $fullImage = asset(config('image.books.storage') . $image);
        }
        return asset($fullImage);
    }

    /**
     * Save book from excel
     *
     * @param array $qrCode qrcode's attribute
     * @param array $data   book's data
     *
     * @return App\Model\User
     */
    public static function updateOrCreateBook($qrCode, $data)
    {
        $qrcode = QrCode::withTrashed()->where([['prefix', $qrCode['prefix']], ['code_id', $qrCode['code_id']]]);
        if ($qrcode->exists()) {
            $book = Book::withTrashed()->updateOrCreate(['id' => $qrcode->first()['book_id']], $data);
            self::restore($qrcode->first()['book_id']);
            return $book;
        } else {
            return Book::create($data);
        }
    }

    /**
     * Restore book and its relationship with id of book.
     *
     * @param int $id id of book
     *
     * @return boolean
     */
    public static function restore($id)
    {
        $deletedTime = Book::withTrashed()->where('id', $id)->pluck('deleted_at')->first();
        //Get all posts ID was restored and its comments ID.
        $postsID = Post::withTrashed()->where('book_id', $id)->where('deleted_at', $deletedTime)->pluck('id')->toArray();
        $commentsID = Comment::withTrashed()->where('deleted_at', $deletedTime)->whereIn('post_id', $postsID)->pluck('id')->toArray();
        //Restore book and its favorite.
        $restored = Book::withTrashed()->whereNotNull('deleted_at')->where('id', $id)->restore();
        if ($restored === 0) {
            return false;
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

        return true;
    }
}
