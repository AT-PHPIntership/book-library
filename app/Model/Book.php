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

class Book extends Model
{
    use Sortable;

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
        'status'
    ];

    /**
     * Relationship morphMany with Favorite
     * Declare table sort
     *
     * @var array $sortable table sort
     */
    public $sortable = ['id', 'name', 'author', 'avg_rating'];

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
     * Get total Borrow
     *
     * @return int
     */
    public function getTotalBorrowAttribute()
    {
        return $this->borrowings->count();
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
     * Scope search book by name
     *
     * @param \Illuminate\Database\Eloquent\Builder $query query of Model
     * @param String                                $name  name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchName($query, $name)
    {
        return $query->where('name', 'LIKE', '%'.$name.'%');
    }

    /**
     * Scope search book by author
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  query of Model
     * @param String                                $author author
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAuthor($query, $author)
    {
        return $query->where('author', 'LIKE', '%'.$author.'%');
    }

    /**
     * Upload image
     *
     * @param App\Http\Requests\BookEditRequest $request  request
     * @param String                            $oldImage old image name
     *
     * @return String
     */
    public function uploadImage($request)
    {
        $image = $request->image;
        $folder = config('image.books.upload_path');
        $path = Storage::disk('public')->putFile($folder, $request->file('image'));
        return $path;
    }
}
