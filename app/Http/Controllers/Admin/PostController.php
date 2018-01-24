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
        $comments = Comment::with(['parent', 'children'])->whereHas('post', function ($query) use ($id) {
            $query->where('post_id', '=', $id);
        })->get();
        $posts = DB::select('select posts.* ,ratings.rating , users.name
                            from posts, ratings, users
                            where posts.user_id = ratings.user_id and posts.book_id = ratings.book_id
                                and users.id = posts.user_id and posts.id = '.$id.'');

        return view('backend.posts.show', compact('posts', 'comments'));
    }
}
