<?php

namespace App\Model;

use App\Model\User;
use App\Model\Borrowing;
use App\Model\Rating;
use App\Model\Donator;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use Sortable;

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
        'QRcode',
        'category_id',
        'name',
        'author',
        'year',
        'price',
        'description',
        'donate_by',
        'donator_id',
        'avg_rating',
        'total_rating',
        'image',
        'status'
    ];

    /**
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
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
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
     * Relationship hasMany with Borrow
     *
     * @return array
    */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
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
}
