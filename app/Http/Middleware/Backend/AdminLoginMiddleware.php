<?php

namespace App\Http\Middleware\Backend;

use Closure;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == User::$role['admin']) {
                return $next($request);
            }
            return redirect('/home')
                ->withErrors(['message' => trans('portal.messages.not_an_admin')]);
        }
    }
}
