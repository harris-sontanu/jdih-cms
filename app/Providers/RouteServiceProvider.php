<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\Legislation;
use App\Models\Post;
use App\Models\Media;
use App\Models\Link;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
        });

        Route::bind('law', function ($value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('monograph', function ($value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('article', function ($value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('judgment', function ($value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('news', function ($value) {
            return Post::where('id', $value)->firstOrFail();
        });

        Route::bind('image', function ($value) {
            return Media::where('id', $value)->firstOrFail();
        });

        Route::bind('file', function ($value) {
            return Media::where('id', $value)->firstOrFail();
        });

        Route::bind('youtube', function ($value) {
            return Link::where('id', $value)->firstOrFail();
        });

        Route::bind('banner', function ($value) {
            return Link::where('id', $value)->firstOrFail();
        });

        Route::bind('jdih', function ($value) {
            return Link::where('id', $value)->firstOrFail();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
