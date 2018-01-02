<?php

namespace App\Model;

use App\Model\Post;
use App\Model\User;
use App\Model\Like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'post';

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
     * Get all of the owning postable models
     *
     * @return array
    */
    public function postable()
    {
        return $this->morphTo();
    }
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
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
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
