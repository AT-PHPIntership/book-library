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
     * Value of review post
     */
    const REVIEW_TYPE = 1;

    /**
     * Value of status post
     */
    const STATUS_TYPE = 2;

    /**
     * Value of find book post
     */
    const FIND_TYPE = 3;

    /**
      * The default avatar of the user
      */
    const DEFAULT_IMAGE_POST = 'no-image.png';

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

    /**
    * Custom format image if has not so default image
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? $this->image : asset(config('image.posts.path_upload').self::DEFAULT_IMAGE_POST);
    }

    /**
     * Custom format lable type by review, status, find book
     *
     * @return mixed
     */
    public function getTypeLableAttribute()
    {
        switch ($this->type) {
            case self::REVIEW_TYPE:
                return ['#activity', __('post.review')] ;
                break;
            case self::STATUS_TYPE:
                return ['#timeline', __('post.status')] ;
                break;
            case self::FIND_TYPE:
                return ['#settings', __('post.find_book')] ;
                break;
        }
    }

    /**
     * Get post data
     *
     * @param array $addingFields adding some needed fields
     *
     * @return App\Model\Post
     */
    public static function getPost($addingFields = null)
    {
        $fields = [
            'posts.id',
            'posts.content',
            'posts.type',
            'users.name',
            'users.team',
            'users.avatar_url',
            'posts.created_at'
        ];

        if ($addingFields != null) {
            $fields = array_merge($fields, $addingFields);
        }

        return self::select($fields)->withCount('favorites')
                                    ->withCount('comments')
                                    ->join('users', 'posts.user_id', 'users.id')
                                    ->leftJoin('books', 'posts.book_id', 'books.id');
    }
}
