<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param App\Http\Requests\Backend\LoginRequest $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        # Collect data form request
        $data = $request->except('_token');
        // dd($data);
        try {
            # Try to call API to Portal
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());
            return response()->json([
                'meta' => $portalResponse->meta,
                'data' => $portalResponse->data->user
            ], Response::HTTP_OK);
        } catch (ServerException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => trans('portal.messages.' . $portalResponse->meta->messages)]);
        }
    }
}
