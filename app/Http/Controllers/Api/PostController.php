<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Get list post of user
     *
     * @param Request $request request
     * @param int     $id      id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function getListPostOfUser(Request $request, $id)
    {
        $posts = Post::getPost()
                    ->where('user_id', $id);
        if ($request->has('type')) {
            $type = $request->type;
            $posts = $posts->where('type', $type);
        }
        $posts = $posts->paginate(config('define.post.page_length'));
        return metaResponse($posts);
    }
}
