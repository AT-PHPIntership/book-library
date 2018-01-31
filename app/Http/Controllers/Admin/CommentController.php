<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;

class CommentController extends Controller
{
    /**
     * Delete comment by Post
     *
     * @param Request $request request
     * @param int     $id      id of comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Comment::find($id)->delete();
        if ($request->ajax()) {
            return response()->json(204);
        }
    }
}
