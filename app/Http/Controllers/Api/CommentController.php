<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Model\Post;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\Api\NewCommentRequest;
use Symfony\Component\HttpFoundation\Response;

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
     * Update comment in Posts
     *
     * @param CommentUpdateRequest $request Request update comment
     * @param int                  $id      id of comment
     *
     * @return mixed
     */
    public function update(CommentUpdateRequest $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $userId = $this->user->id;
            if ($comment->user_id != $userId) {
                return metaResponse(null, Response::HTTP_FORBIDDEN, __('comment.messages.not_permission'));
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => __('comment.messages.not_found')
                ]
            ], Response::HTTP_NOT_FOUND);
        }
        $comment->fill($request->all());
        $comment->save();
        return metaResponse(['data' => $comment]);
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
            return metaResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, config('define.messages.error_occurred'));
        }
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
