<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Value of root admin
     */
    const ROOT_ADMIN = 1;

    /**
     * The default avatar of the user
     */
    const DEFAULT_AVATAR = 'avatar-default.jpg';

    /**
     * Value of SA
     */
    const SA = 'SA';

    /**
     * Value of PHP
     */
    const PHP = 'PHP';

    /**
     * Value of QC
     */
    const QC = 'QC';

    /**
     * Value of ANDROID
     */
    const ANDROID = 'Android';

    /**
     * Value of IOS
     */
    const IOS = 'IOS';

    /**
     * Value of ADMIN
     */
    const ADMIN = 'Admin';

    /**
     * Value of USER
     */
    const USER = 'User';

    /**
     * Value of ROLE_ADMIN
     */
    const ROLE_ADMIN = 1;

    /**
     * Value of ROLE_USER
     */
    const ROLE_USER = 0;

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
        'id',
        'employee_code',
        'name',
        'email',
        'team',
        'avatar_url',
        'role',
        'access_token',
        'expired_at',
        'created_at'
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
     * Relationship hasMany with Comment
     *
     * @return array
    */
    public function comments()
    {
        return $this->hasMany(Comment::class);
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

    /**
     * Get avatar of user
     *
     * @return array
    */
    public function getAvatarAttribute()
    {
        return $this->avatar_url ? $this->avatar_url : asset(config('image.users.path_upload') . self::DEFAULT_AVATAR);
    }
}
