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
            $user = $this->saveUser($portalResponse, $request);
        if (isset($user['errors']['message'])) {
            return metaResponse(null, $user['errors']['code'], $user['errors']['message']);
        }
            return  metaResponse(['data' => $user]);
    }
    
    /**
     * Save data users
     *
     * @param array                    $userResponse userResponse
     * @param \Illuminate\Http\Request $request      request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($userResponse, $request)
    {
        try {
            # Collect user data from response
            $userCondition = [
                'employee_code' => $userResponse[0]->employee_code,
                'email' => $request->email,
            ];
            $user = [
                'name' => $userResponse[0]->name,
                'team' => $userResponse[0]->teams[0]->name,
                'access_token' => $userResponse['access_token'],
                'avatar_url' => $userResponse[0]->avatar->file,
            ];
            if ($userResponse[0]->teams[0]->name == User::SA) {
                $user['role'] = User::ROOT_ADMIN;
            }
            # Get user from database OR create User
            return User::updateOrCreate($userCondition, $user);
        } catch (\Exception $e) {
            # Catch errors from Portal
            return $userResponse;
        }
    }
}
