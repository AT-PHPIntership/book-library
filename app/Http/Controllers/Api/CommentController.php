<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Model\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param CommentUpdateRequest  $request Request update comment
     * @param int                   $id      id of comment
     *
     * @return mixed
     */
    public function update(CommentUpdateRequest $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $userId = $this->user->id;
            if ($comment->user_id != $userId) {
                return metaResponse(null, Response::HTTP_FORBIDDEN, 'You dont have permission to edit');
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Comment not found'
                ]
            ], Response::HTTP_NOT_FOUND);
        }
        $comment->fill($request->all());
        $comment->save();
        return metaResponse($comment);
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
}
