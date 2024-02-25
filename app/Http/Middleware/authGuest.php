<?php

namespace App\Http\Middleware;
use Closure;
use App;
class authGuest
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
        app()->setlocale('en');
        if($request->header('lang') != null)
        {
            app()->setlocale($request->header('lang'));
        }
        if($request->header('Apipassword') != 'fastworld2023@#$fosh$')
        {
            return response()->json([
                'status'=>'0',
                'message'=>__("site.You Are Not Authorized"),
            ]);
        }

        return $next($request)
			 ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Credentials', true)
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type')
            ->header('Access-Control-Allow-Headers', 'Origin,Accept, Content-Type, Authorization');
    }
}
