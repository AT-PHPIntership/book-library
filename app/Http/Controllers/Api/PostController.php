<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Model\User;
use App\Model\Book;
use App\Model\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Add new review Post
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $this->user->id;
        $content = $request->get('content');
        $bookId = $request->get('book_id');
        $findBook = $request->get('find_book');
        if (isset($bookId)) {
            $type = Post::REVIEW_TYPE;
        } elseif ($findBook === 0) {
            $type = Post::STATUS_TYPE;
        } else {
            $type = Post::FIND_TYPE;
        }
        $reviewPost = Post::create([
            'user_id'=> $userId,
            'content' => $content,
            'book_id' => $bookId,
            'type' => $type,
        ]);
        if ($request->get('rating')) {
            $ratingPost = Rating::create([
                    'user_id'=> $userId,
                    'book_id' => $bookId,
                    'rating' => $request->get('rating'),
            ]);
        }
        $data = [
            'reviewPost' => $reviewPost,
            'ratingPost' => $ratingPost,
        ];
        return metaResponse($data, Response::HTTP_CREATED);
    }
}
