<?php

namespace App\Model;

use App\Model\Book;
use App\Model\Borrow;
use App\Model\Favorite;
use App\Model\Post;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    const ROOT_ADMIN = 1;

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
    public function postsFavorite()
    {
        return $this->belongsToMany(Post::class);
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
     * Relationship hasMany with Favorite
     *
     * @return array
    */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get Role user
     *
     * @return array
    */
    public function getRoleNameAttribute()
    {
        return $this->role == self::ROOT_ADMIN ? __('user.admin') : __('user.member');
    }
}
