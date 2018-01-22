<?php

namespace App\Http\Middleware\Backend;

use Closure;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class TeamSAMiddleware extends Middleware
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
        if (Auth::user()['team'] == User::SA) {
            return $next($request);
        }
        return app()->abort(Response::HTTP_FORBIDDEN, 'Permission denied');
    }
}
