<?php

namespace App\Http\Controllers\Api;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\Post;
use Symfony\Component\HttpFoundation\Response;
use App\Model\User;
use App\Http\Requests\Api\NewCommentRequest;

class CommentController extends ApiController
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
     * Delete comment by Post
     *
     * @param int $id id of comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Comment::findOrFail($id)->delete();
            if (request()->ajax()) {
                return response()->json(Response::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return response()->json(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Create api new comment.
     *
     * @param NewCommentRequest $request Request add new comment
     * @param Post              $post    Comment of this post
     *
     * @return Response
     */
    public function store(NewCommentRequest $request, Post $post)
    {
        $request['user_id'] = $this->user->id;
        $request['post_id'] = $post->id;

        //Add new Comment
        try {
            $comment = Comment::create($request->all());
        } catch (\Exception $e) {
            \Log::error($e);
            return metaResponse(null, Response::HTTP_BAD_REQUEST, config('define.messages.error_occurred'));
        }

        $comment = Comment::find($comment->id);
        return metaResponse(['data' => $comment], Response::HTTP_CREATED);
    }
    
    /**
     * Get all child comment for one comment
     *
     * @param integer $id parent comment's id
     *
     * @return Illuminate\Http\Response
     */
    public function getChildComments($id)
    {
        $comments = Comment::getChildComments($id);
        
        return metaResponse($comments);
    }
}
