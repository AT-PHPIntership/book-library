<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Rating;
use App\Model\Comment;
use DB;

class PostController extends Controller
{
    /**
     * Display a list of Posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'posts.id',
            'users.name',
            'type',
            'posts.content',
            'posts.created_at',
        ];
        $posts = Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                    ->select($fields)
                    ->withCount('comments')
                    ->paginate(config('define.page_length'));
        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Display Layout Post Detail.
     *
     * @param int $id id
     *
     * @return mixed
     */
    public function show($id)
    {
        $comments = Comment::where('post_id', $id)->get();

        $post = Post::select('posts.*', 'ratings.rating')
                ->join('ratings', function ($join) {
                    $join->on('posts.user_id', '=', 'ratings.user_id');
                    $join->on('posts.book_id', '=', 'ratings.book_id');
                })->find($id);
        if (!$post) {
            return redirect('admin/posts');
        }
        $chilComments = $this->showComment($comments);
        return view('backend.posts.show', compact('post', 'chilComments'));
    }

    /**
     * Display Layout Post Detail.
     *
     * @param array $comments  comments
     * @param int   $parentId parent id
     *
     * @return mixed
     */
    public function showComment($comments, $parentId = null)
    {
        $body = '<div class="list-group">';
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                    $body .= '<div href="#" class="list-group-item list-group-item-action flex-column align-items-start">';
                    $body .= '<p class="mb-1">'. $comment['content'].'<a href="#" class="glyphicon glyphicon-remove text-warning pull-right"></a></p>';
                    $body .= $this->showComment($comments, $comment->id);
                    $body .= '</div>';
            }
        }
        $body .= '</div>';
        return $body;
    }
}
