<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;

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
     * Display User Detail.
     *
     * @return mixed
     */
    public function show()
    {
        return view('backend.posts.show');
    }
}
