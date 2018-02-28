<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Model\User;
use App\Model\Book;
use Illuminate\Http\Request;

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
        $image = Book::select('image')->where('id', $bookId)->first();
        $findBook = $request->get('find_book');
        if (isset($bookId)) {
            $type = Post::REVIEW_TYPE;
        } else if ($findBook === 0) {
            $type = Post::STATUS_TYPE;
        } else {
            $type = Post::FIND_TYPE;
        }
        $reviewPost = Post::create([
        'user_id'=> $userId,
        'content' => $content,
        'bookId' => $bookId,
        'type' => $type,
        'image' => $image,
        ]);
        return metaResponse($reviewPost);
    }
}
