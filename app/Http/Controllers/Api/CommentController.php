<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\Comment;
use App\Model\Post;
use Symfony\Component\HttpFoundation\Response;
use App\Model\User;
use App\Http\Requests\Api\ApiNewCommentRequest;

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
     * @param Request $request CreateCommentRequest
     * @param Int     $id      Id of post
     *
     * @return Response
     */
    public function store(ApiNewCommentRequest $request, $id)
    {
        //Validate post id
        if (!Post::find($id)) {
            return metaResponse(null, Response::HTTP_NOT_FOUND, config('define.messages.post_not_found'));
        }

        //Validate exsist parent_id comment
        if (!Comment::find($request->parent_id)) {
            return metaResponse(null, Response::HTTP_NOT_FOUND, config('define.messages.parent_id_not_found'));
        }

        //Validate exsist user
        if (!User::find($this->user->id)) {
            return metaResponse(null, Response::HTTP_NOT_FOUND, config('define.messages.user_not_found'));
        }

        $request['user_id'] = $this->user->id;
        $request['post_id'] = $id;

        //Add new Comment
        try {
            $comment = Comment::create($request->all());
        } catch (\Exception $e) {
            return metaResponse(null, Response::HTTP_BAD_REQUEST, config('define.messages.error_occurred'));
        }
        return metaResponse(['data' => $comment], Response::HTTP_CREATED);
    }
}
