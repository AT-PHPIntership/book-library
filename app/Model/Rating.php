<?php

namespace App\Model;

use App\Model\Book;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
    ];

    /**
     * Relationship belongsTo with Book
     *
     * @return array
    */
    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
