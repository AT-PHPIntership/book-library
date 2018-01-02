<?php

namespace App\Model;

use App\Model\Book;
use App\Model\User;
use App\Model\Like_and_Share;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'type',
        'content',
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

    /**
     * Relationship belongsToMany with User
     *
     * @return array
    */
    public function userPosts()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relationship hasMany with Like_and_Share
     *
     * @return array
    */
    public function likesAndShares()
    {
        return $this->hasMany(Like_and_Share::class);
    }
}