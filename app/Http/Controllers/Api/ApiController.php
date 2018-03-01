<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
     /**
     * The Book implementation.
     *
     * @var user
     */
    public $user;

    /**
     * Create a new controller instance.
     *
     * @param Illuminate\Http\Request $request request
     * @param App\Model\User          $user    instance of User
     *
     * @return void
     */
    public function __construct(Request $request, User $user)
    {
        $accessToken = $request->headers->get('token');
        if ($accessToken != null) {
            $user = $user->where('access_token', '=', $accessToken)->first();
        }
        $this->user = $user;
    }
}
