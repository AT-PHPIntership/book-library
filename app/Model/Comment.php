<?php

namespace App\Model;

use App\Model\Post;
use App\Model\User;
use App\Model\Favorite;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use SoftDeletes;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id',
    ];

    /**
     * Relationship belongsTo with Post
     *
     * @return array
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship morphMany with Favorite
     *
     * @return array
    */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
