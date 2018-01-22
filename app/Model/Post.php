<?php

namespace App\Model;

use App\Model\User;
use App\Model\Comment;
use App\Model\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Post extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    
    /**
     * Soft Delete Relationship 
     */
    protected $cascadeDeletes = ['favorites', 'comments'];
    
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

    /**
     * Custom delete method.
     *
     * @return array
    */
    public function delete()
    {
        $this->boot();
        parent::delete();
    }
}
