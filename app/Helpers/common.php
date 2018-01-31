<?php

use App\Model\User;
use App\Model\Book;
use App\Model\Post;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('getCount')) {

  /**
  * Get percent progress name of database
  *
  * @param string $class class name
  *
  * @return int
  */
    function getCount($class)
    {
        $count = 0;
        if (class_exists($class) && app($class) instanceof Model) {
            $count = app($class)->count();
        }
        return $count;
    }
}

if (!function_exists('activeRoute')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param Array  $routes routes action
     * @param string $output active or ''
     *
     * @return string
     */
    function activeRoute(array $routes, $output = "active")
    {
        if (in_array(Route::currentRouteName(), $routes, true)) {
            return $output;
        }
    }

    /**
     * Display Layout Post Detail.
     *
     * @param array $comments comments
     * @param int   $parentId parent id
     *
     * @return mixed
     */
    function showComment($comments, $parentId = null)
    {
        $body = '<div class="row comment-list">';
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $body .= '<div class="col-md-12 comment-item">';
                    $body .= '<div class="row">';
                        $body .= '<div class="col-md-1 comment-img">';
                            $body .= '<div class="pull-left">';
                                $body .= '<img class="img-thumbnail" src="'.$comment->user->avatar.'" alt="User profile picture">';
                            $body .= '</div>';
                        $body .= '</div>';
                        $body .= '<div class="col-md-11 comment-content">';
                            $body .= '<div class="panel panel-default">';
                                $body .= '<div class="panel-heading">'.$comment->user->name.'<a href="#" class="glyphicon glyphicon-remove text-warning pull-right confirm-delete" data-id="'.$comment['id'].'" data-toggle="modal" data-target="#confirmDeleteComment"></a></div>';
                                $body .= '<div class="panel-body">'.$comment['content'].'</div>';
                            $body .= '</div>';
                            $body .= '<div class="col-md-12 comment-item">';
                                $body .= '<div class="row">'.showComment($comments, $comment->id).'</div>';
                            $body .= '</div>';
                        $body .= '</div>';
                    $body .= '</div>';
                $body .= '</div>';
            }
        }
        $body .= '</div>';
        return $body;
    }
}
