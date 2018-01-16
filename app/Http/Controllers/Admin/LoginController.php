<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ServerException;
use App\Http\Requests\Backend\LoginRequest;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('backend.users.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param App\Http\Requests\Backend\LoginRequest $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        # Collect data form request
        $data = $request->except('_token');
        try {
            # Try to call API to Portal
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());

            # Check status API response
            if ($portalResponse->meta->status == config('define.success')) {
                $userResponse = $portalResponse->data->user;
                # Collect user data from response
                $teamName = $userResponse->teams[0]->name;
                $date = date(config('define.datetime_format'), strtotime($userResponse->expires_at));
                $userCondition = [
                    'employee_code' => $userResponse->employee_code,
                    'email' => $request->email,
                ];
                $user = [
                    'name' => $userResponse->name,
                    'team' => $teamName,
                    'access_token' => $userResponse->access_token,
                    'expired_at' => $date,
                    'avatar_url' => $userResponse->avatar_url
                ];
                if ($teamName == User::SA) {
                    $user['role'] = User::ROOT_ADMIN;
                }
                # Update user from database OR create User
                $user = User::updateOrCreate($userCondition, $user);
                # Set login for user
                Auth::login($user, $request->filled('remember'));
                return redirect("/admin");
            }
        } catch (ServerException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => trans('portal.messages.' . $portalResponse->meta->messages)]);
        } catch (Exception $e) {
            echo  $e->getMessage();
        }
    }
    
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}
