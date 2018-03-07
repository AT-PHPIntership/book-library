<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Model\User;
use App\Model\Rating;
use App\Http\Requests\Api\CreatePostRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use DB;

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
 * Store new resource
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
        $ratingPost = null;

        if ($request->type == Post::REVIEW_TYPE) {
            $ratingPost = Rating::create($request->all());
        }
        DB::commit();
        $data = [
            'reviewPost' => $post,
            'ratingPost' => $ratingPost,
        ];
        return metaResponse($data, Response::HTTP_CREATED);
    } catch (Exception $e) {
        DB::rollBack();
        dd($e);
    }
}
}
