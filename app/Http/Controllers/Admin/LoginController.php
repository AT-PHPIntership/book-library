<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        # Collect data form request
        $data = $request->except('_token');
        try {
            # Try to call API to Portal
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());
        } catch (ServerException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => trans('portal.messages.' . $portalResponse->meta->messages)]);
        }
        
        # Check status API response
        if ($portalResponse->meta->status == 'successfully') {
            $userResponse = $portalResponse->data->user;
            # Collect user data from response
            $user = [
                'employee_code' => $userResponse->employee_code,
                'email' => $request->email,
            ];
            
            # Get user from database OR create User
            $user = User::firstOrNew($user);
            # Update user info
            $user->name = $userResponse->name;
            $user->team = $userResponse->teams[0]->name;
            $user->avatar_url = $userResponse->avatar_url;
            $user->access_token = $userResponse->access_token;
            $user->expires_at = $userResponse->expires_at;
            # Save User, update token
            dd($user);
            $user->save();
            # Set login for user
            Auth::login($user, $request->filled('remember'));
            return redirect("/admin");
        }
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
