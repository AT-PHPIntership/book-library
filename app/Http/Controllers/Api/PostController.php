<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Model\Post;

class PostController extends Controller
{
    /**
     * Get all post's comments
     *
     * @param integer $id post's id
     *
     * @return Illuminate\Http\Response
     */
    public function getCommentsOfPost($id)
    {
        $comments = Comment::getParentComments($id);
        
        return metaResponse($comments);
    }
}
