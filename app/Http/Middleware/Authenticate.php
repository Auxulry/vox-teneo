<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null|JsonResponse
     */
    protected function redirectTo($request)
    {
        if (
            $request->is('api/v1/*') &&
            !Auth::guard(config('auth.guards.api.name'))->check()
        ) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'status' => Response::$statusTexts[Response::HTTP_UNAUTHORIZED]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return route('welcome');
    }
}
