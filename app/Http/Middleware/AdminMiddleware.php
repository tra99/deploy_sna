<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Enum;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

use App\Enum\UserType;

class AdminMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if($user->type_id !=  UserType::ADMIN && $user->type_id != UserType::STAFF ){

            return response()->json([
                'message' => 'Invalid access',
                'user'    => $user
            ], Response::HTTP_UNAUTHORIZED);
        }


        return $next($request);
    }
}
/*
|--------------------------------------------------------------------------
| Custom middleware by: Yim Klok
|--------------------------------------------------------------------------
|
| date: 22/02/2023. location: Manistry of public works and transport - MPWT
|
*/
