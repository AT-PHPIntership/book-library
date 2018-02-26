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
     * Default value of filter type books is donated books
     */
    const DONATED = 'donated';

    /**
     * Default value of filter type books is borrowed books
     */
    const BORROWED = 'borrowed';

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
        'input' => [
            ['name', 'like'],
            ['author', 'like'],
        ],
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
}
