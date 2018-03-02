<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Backend\LoginRequest;
use Exception;

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
            $userResponse = callAPIPortal($request);
            $teamName = $userResponse[0]->teams[0]->name;
            $userCondition = [
                'employee_code' => $userResponse[0]->employee_code,
                'email' => $request->email,
            ];
            $user = [
                'name' => $userResponse[0]->name,
                'team' => $teamName,
                'access_token' => $userResponse['access_token'],
                'avatar_url' => $userResponse[0]->avatar->file
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
        } catch (\Exception $e) {
            # Catch errors from Portal
            $userResponse = callAPIPortal($request);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => trans('portal.messages.' . $userResponse->errors->message)]);
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
