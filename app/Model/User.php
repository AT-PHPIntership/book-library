<?php

namespace App\Model;

use App\Model\Post;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Comment;
use App\Model\Like_and_Share;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emplyee_code',
        'name',
        'email',
        'team',
        'avatar_url',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
     * Relationship belongsToMany with Book
     *
     * @return array
    */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    /**
     * Relationship belongsToMany with Book
     *
     * @return array
    */
    public function postsLikeShare()
    {
        return $this->belongsToMany(Post::class);
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
     * Relationship hasMany with Like_and_Share
     *
     * @return array
    */
    public function likeAndShare()
    {
        return $this->hasMany(Like_and_Share::class);
    }

    /**
     * Relationship hasMany with Information
     *
     * @return array
    */
    public function informations()
    {
        return $this->hasMany(Information::class);
    }

    /**
     * Relationship hasMany with Comment
     *
     * @return array
    */
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
