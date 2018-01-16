<?php

namespace App\Model;

use App\Model\User;
use App\Model\Comment;
use App\Model\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
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
        'postable_id',
        'postable_type',
        'type',
        'content',
        'image'
    ];
    
    /**
     * Relationship morphMany with Favorite
     *
     * @return array
    */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
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
     * Relationship hasMany with Comment
     *
     * @return array
    */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
