<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Backend\LoginRequest;
use App\Model\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Response;

class LoginController extends ApiController
{
    /**
     * Handle a login request to the application.
     *
     * @param App\Http\Requests\Backend\LoginRequest $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
            $portalResponse = callAPIPortal($request);
        if ($portalResponse->meta->code == Response::HTTP_OK) {
            $user = $this->saveUser($portalResponse, $request);
                
            return  response()->json([
            'meta' => $portalResponse->meta,
            'data' => $user,
            ], Response::HTTP_OK);
        }
    }
    
    /**
     * Save data users
     *
     * @param App\Http\Controllers\Auth $portalResponse portalResponse
     * @param \Illuminate\Http\Request  $request        request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($portalResponse, $request)
    {
        $userResponse = $portalResponse->data->user;
        # Collect user data from response
        $date = date(config('define.datetime_format'), strtotime($userResponse->expires_at));
        $userCondition = [
            'employee_code' => $userResponse->employee_code,
            'email' => $request->email,
        ];
        $user = [
            'name' => $userResponse->name,
            'team' => $userResponse->teams[0]->name,
            'expired_at' => $date,
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
