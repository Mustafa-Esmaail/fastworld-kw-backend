<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */

     protected $namespace = 'App\Http\Controllers';
    // protected $namespaceTeacher = 'App\Http\Controllers\Api\Teacher';
    protected $namespaceOwner = 'App\Http\Controllers\Api\Owner';
    protected $namespaceGuest = 'App\Http\Controllers\Api\Guest';

    public const HOME = '/dashboard/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

                Route::prefix('owner')
                ->middleware('api')
                ->namespace($this->namespaceOwner)
                ->group(base_path('routes/owner.php'));

                Route::prefix('guest')
                ->middleware('authGuest')
                ->namespace($this->namespaceGuest)
                ->group(base_path('routes/api.php'));
        });
    }
}
