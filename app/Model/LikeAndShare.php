<?php

namespace App\Model;

use App\Model\Post;
use Illuminate\Database\Eloquent\Model;

class LikeAndShare extends Model
{
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
        'user_id',
        'post_id',
        'like',
        'share',
    ];
    
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
     * Relationship belongsTo with Post
     *
     * @return array
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
