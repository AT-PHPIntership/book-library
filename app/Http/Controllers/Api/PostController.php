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
     * @param int     $id      id of user
     *
     * @return \Illuminate\Http\Response
     */
    public function getListPostOfUser(Request $request, $id)
    {
        $fields = [
            'books.name as book_name',
            'books.image',
            'posts.updated_at',
            'books.avg_rating',
        ];
        $posts = Post::getPost($fields)
                        ->where('users.id', $id);
        if ($request->has('type')) {
            $postTypes = config('define.type_post');
            $type = $request->type;
            foreach ($postTypes as $postType) {
                if ($postType == $type) {
                    $posts = $posts->where('type', $type);
                }
            }
        }
        $posts = $posts->paginate(config('define.post.page_length'));
        return metaResponse($posts);
    }
}
