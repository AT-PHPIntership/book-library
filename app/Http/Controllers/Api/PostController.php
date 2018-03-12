<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Model\User;
use App\Model\Rating;
use App\Model\Comment;
use App\Http\Requests\Api\CreatePostRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use DB;
use Storage;

class PostController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @param Illuminate\Http\Request $request request
     * @param App\Model\User          $user    instance of User
     *
     * @return void
     */
    public function __construct(Request $request, User $user)
    {
        parent::__construct($request, $user);
    }

    /**
     * Add new Post
     *
     * @param CreatePostRequest $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        if ($request->type != Post::REVIEW_TYPE) {
            $request['book_id'] = null;
        }
        $request['user_id'] = $this->user->id;
        DB::beginTransaction();
        try {
            // Create post
            $post = Post::create($request->all());

            // Create rating when post's type is review
            if ($request->type == Post::REVIEW_TYPE) {
                $ratingPost = Rating::create($request->all());
            }
            // Create image when choose find type
            if ($request->type == Post::FIND_TYPE) {
                $data = $request->toArray();
                $folder = config('image.posts.upload_path');
                $path = Storage::disk('public')->putFile($folder, $request->file('image'));
                $data['image'] = $path;
                $post = Post::create($data);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
        }
        $data = [
            'reviewPost' => $post,
            'ratingPost' => $ratingPost ?? null,
        ];
        return metaResponse($data, Response::HTTP_CREATED);
    }
    
    /**
     * Get all post's comments
     *
     * @param integer $id post's id
     *
     * @return Illuminate\Http\Response
     */
    public function getCommentsOfPost($id)
    {
        $comments = Comment::getParentComments($id);
        return metaResponse($comments);
    }
}
