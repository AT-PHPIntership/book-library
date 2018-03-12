<?php

namespace App\Http\Controllers\Api;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
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
