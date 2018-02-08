<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\ServerException;

class LoginController extends ApiController
{
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->except('_token');
        try {
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());
            if ($portalResponse->meta->code == Response::HTTP_OK) {
                $user = $this->saveUser($portalResponse, $request);
                return  response()->json([
                    'meta' => $portalResponse->meta,
                    'data' => $user,
                ], Response::HTTP_OK);
            }
        } catch (ServerException $e) {
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            $message = $portalResponse->meta->messages;
            $error = null;
            switch ($message) {
                case config('portal.messages_key.not_correct'):
                    $error = trans('portal.messages.' . $portalResponse->meta->messages);
                    break;
                case config('portal.messages_key.not_empty'):
                    $error = trans('portal.messages.' . $portalResponse->meta->messages);
                    break;
                case config('portal.messages_key.user'):
                    $error = trans('portal.messages.not_an_admin');
                    break;
                default:
                    $error = trans('portal.messages.not_an_admin');
                    break;
            }
            return response()->json([
                'meta' => $portalResponse->meta,
                'error' => $error
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Save data users
     *
     * @param App\Http\Controllers\Auth $portalResponse $portalResponse
     * @param \Illuminate\Http\Request  $request        $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($portalResponse, $request)
    {
        $userResponse = $portalResponse->data->user;
        # Collect user data from response
        $userCondition = [
            'employee_code' => $userResponse->employee_code,
            'email' => $request->email,
        ];
        $user = [
            'name' => $userResponse->name,
            'team' => $userResponse->teams[0]->name,
            'expires_at' => date(config('define.login.datetime_format'), strtotime($userResponse->expires_at)),
            'avatar_url' => $userResponse->avatar_url,
            'access_token' => $userResponse->access_token,
        ];
        if ($userResponse->teams[0]->name == User::SA) {
            $user['role'] = User::ROOT_ADMIN;
        }
        # Get user from database OR create User
        return User::updateOrCreate($userCondition, $user);
    }
}
