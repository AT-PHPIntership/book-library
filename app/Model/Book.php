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
     * Scope search by name
     *
     * @param Model  $query  query
     * @param String $search search
     *
     * @return mixed
     */
    public function scopeSearchName($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%');
    }

    /**
     * Scope search by name
     *
     * @param Model  $query  query
     * @param String $search search
     *
     * @return mixed
     */
    public function scopeSearchAuthor($query, $search)
    {
        return $query->where('author', 'like', '%'.$search.'%');
    }

    /**
     * Scope search by name
     *
     * @param Model  $query  query
     * @param String $name   name
     * @param String $author author
     *
     * @return mixed
     */
    public function scopeSearchNameAuthor($query, $name, $author)
    {
        return $query->where('name', 'like', '%'.$name.'%')
        ->orWhere('author', 'like', '%'.$author.'%');
    }
}
