<?php

namespace App\Model;

use App\Model\User;
use App\Model\Rating;
use App\Model\Donator;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'book';
    const ROW_LIMIT = 10;

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
        'donate_by',
        'avg_rating',
        'total_rating',
        'image',
        'status'
    ];

    // protected $appends = ['total_borrow'];

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
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Get total Borrow
     *
     * @return array
    */
    public function getTotalBorrowAttribute()
    {
        return $this->borrows->count();
    }
}
