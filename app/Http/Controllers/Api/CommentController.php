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
     *
     * @return Response
     */
    public function store(ApiNewCommentRequest $request, $id)
    {
        //Validate post id
        if(!Post::find($id)) {
            return $this->showMessageAndCode(config('define.messages.post_not_found'), Response::HTTP_NOT_FOUND);
        }
        $request['post_id'] = $id;
        $request['user_id'] = $this->user->id;

        //Add new Comment
        try {
            $comment = Comment::create($request->all());
        } catch (\Exception $e) {
            return $this->showMessageAndCode(config('define.messages.error_occurred'), Response::HTTP_BAD_REQUEST);
        }
        return metaResponse(['data' => $comment], Response::HTTP_CREATED);
    }

    /**
     * Show message and code.
     *
     * @param String $message message return
     * @param int    $code    code return
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessageAndCode($message, $code)
    {
        return response()->json([
            'meta' => [
                'code' => $code,
                'message' => $message
            ],
        ], $code);
    }
}
