<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Rating;
use App\Model\Comment;
use DB;
use Illuminate\Database\QueryException;

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

        return view('backend.posts.show', compact('post', 'comments'));
    }

    /**
     * Delete post
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            if($post != null){
                $post->delete();
                flash(__('post.message.success'))->success();
            } else {
                flash(__('post.message.not_exist'))->error();
            }
            DB::commit();
            return redirect()->route('posts.index');
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('post.message.error'))->error();
            return redirect()->back();
        }
    }
}
