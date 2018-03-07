<?php

namespace App\Model;

use App\Model\Post;
use App\Model\User;
use App\Model\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Comment extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    /**
     * Soft Delete Relationship
     */
    protected $cascadeDeletes = ['favorites'];

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

    /**
     * Each comment may have one parent
     *
     * @return array
    */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Each comment may have multiple children
     *
     * @return array
    */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
    * Delete comment by parent id of children.
    *
    * @return void
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($comment) {
            $comment->children()->delete();
        });
    }

    /**
     * Get general query for parent comment or child comment
     *
     * @return App\Model\Comment
     */
    public static function getComment()
    {
        $fields = [
            'comments.id',
            'comments.content',
            'comments.created_at',
            'users.name',
            'users.team',
            'users.avatar_url'
        ];

        return self::select($fields)->withCount('favorites')
            ->join('users', 'users.id', 'comments.user_id');
    }

    /**
     * Get all parent's comments of post
     *
     * @param integer $postId post's id
     *
     * @return array
     */
    public static function getParentComments($postId)
    {
        return self::getComment()
            ->where([
                ['post_id', $postId],
                ['parent_id', null]
            ])
            ->orderBy('comments.created_at', 'desc')
            ->paginate(config('define.comment.limit_render'));
    }

    /**
     * Get all child's comments of comment
     *
     * @param integer $parentId parent comment's id
     *
     * @return array
     */
    public static function getChildComments($parentId)
    {
        return self::getComment()->where('parent_id', $parentId)
            ->orderBy('comments.created_at', 'desc')
            ->paginate(config('define.comment.limit_render'));
    }
}
