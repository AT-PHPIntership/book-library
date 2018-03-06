<?php

namespace App\Http\Middleware\Api;

use App\Model\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginAPIMiddleware
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
        $accessToken = $request->headers->get('token');
        if ($accessToken != null) {
            $user = User::where('access_token', '=', $accessToken)
                        ->firstOrFail();
            if ($user) {
                return $next($request);
            }
            return response()->json([
                'meta' => [
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => config('define.messages.token_not_found')
                ]
            ]);
        }
        return response()->json([
            'meta' => [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => config('define.messages.token_not_found')
            ]
        ]);
    }
}
