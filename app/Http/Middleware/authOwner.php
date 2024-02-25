<?php

namespace App\Http\Middleware;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
class authOwner
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
        try {
            config(['auth.defaults.guard' => 'owner']);
            $user = JWTAuth::parseToken()->authenticate();
            $token = JWTAuth::getToken();
            $payload = JWTAuth::getPayload($token)->toArray();
            if ($payload['type'] != 'owner') {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.Not authorized'),
                ],400);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException ) {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.Token is Invalid'),
                ],400);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.Token is Expired'),
                ],400);
            }
            else if ($e instanceof  TokenBlacklistedException) {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.Token is blacklist'),
                ],400);
            }
            else {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.Authorization Token not found'),
                ],400);
            }
        }

        return $next($request)
         ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Credentials', true)
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type')
            ->header('Access-Control-Allow-Headers', 'Origin,Accept, Content-Type, Authorization');
    }
}
