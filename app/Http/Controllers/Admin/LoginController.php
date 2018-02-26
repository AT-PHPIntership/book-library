<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use GuzzleHttp\Client;
use App\Rules\ATEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        session()->put('url_previous', session()->get('_previous')['url']);
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
       
        try {
            # Try to call API to Portal
            $portalResponse = callAPIPortal($request);
            # Check status API response
            if ($portalResponse->meta->code == Response::HTTP_OK) {
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
                # check redirect to
                $urlPrevious = session()->get('url_previous');
                if (empty($urlPrevious) || $urlPrevious == route('login')) {
                    $urlPrevious = "/";
                }
                session()->forget('url_previous');
                return redirect($urlPrevious);
            }
        } catch (ServerException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => trans('portal.messages.' . $portalResponse->meta->messages)]);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => $e->getMessage()]);
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
