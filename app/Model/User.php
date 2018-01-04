<?php

namespace App\Model;

use App\Model\Post;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Like;
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
        'employee_code',
        'name',
        'email',
        'team',
        'avatar_url',
        'role',
    ];

    /**
     * Value paginate of row
     */
    const ROW_LIMIT = 10;

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
    public function postsLike()
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
     * Relationship hasMany with Like
     *
     * @return array
    */
    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
