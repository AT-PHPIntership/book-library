<?php

use Carbon\Carbon;
use App\Model\User;
use App\Model\Book;
use App\Model\Post;
use App\Model\Category;
use GuzzleHttp\Client;
use App\Rules\ATEmail;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\ClientException;

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

if (!function_exists('canSendMail')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param datetime $sendTime time
     *
     * @return boolean
     */
    function canSendMail($sendTime)
    {
        $now = Carbon::now()->format(config('define.datetime_format'));
        $dateSendMail = Carbon::parse($sendTime)->addDay(config('define.date_diff'))->format(config('define.datetime_format'));
        return ((strtotime($now) >= strtotime($dateSendMail)) && !empty($sendTime)) || empty($sendTime) ? true : false;
    }
}

if (!function_exists('callAPIPortal')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param Array $request request
     *
     * @return array
     */
    function callAPIPortal($request)
    {
        # Collect data form request
        $data = $request->except('_token');
        try {
            # Try to call API to Portal
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());
            $portalUserResponse = $client->request('GET', config('portal.base_url_api') . config('portal.end_point.user_profiles'), [
                'headers' => [
                    'authorization' => $portalResponse->access_token,
                ],
            ]);
            $portalUserResponse = [
                json_decode($portalUserResponse->getBody()->getContents()),
                'access_token' => $portalResponse->access_token,
            ];
            return $portalUserResponse;
        } catch (ClientException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            $portalResponse = [
                'errors' => [
                    'message' => $portalResponse->errors->email_password,
                    'code'  => $e->getCode()
                ]
            ];
            return $portalResponse;
        }
    }
}

if (!function_exists('metaResponse')) {

    /**
     * Add meta response
     *
     * @param Object $data    return data
     * @param int    $code    status of http response
     * @param text   $message message for request  if success or not
     *
     * @return \Illuminate\Http\Response
     */
    function metaResponse($data, $code = 200, $message = null)
    {
        $meta = [
            'meta' => [
                'message' => $message,
                'code' => $code,
            ]
        ];
        $data = collect($meta)->merge($data);
        return response()->json($data, $code);
    }
}
