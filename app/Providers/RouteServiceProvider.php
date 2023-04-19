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
     */
    public function boot(): void
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

        Route::bind('law', function (string $value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('monograph', function (string $value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('article', function (string $value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('judgment', function (string $value) {
            return Legislation::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('news', function (string $value) {
            return Post::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('page', function (string $value) {
            return Post::where('id', $value)->withTrashed()->firstOrFail();
        });

        Route::bind('image', function (string $value) {
            return Media::where('id', $value)->firstOrFail();
        });

        Route::bind('file', function (string $value) {
            return Media::where('id', $value)->firstOrFail();
        });

        Route::bind('youtube', function (string $value) {
            return Link::where('id', $value)->firstOrFail();
        });

        Route::bind('banner', function (string $value) {
            return Link::where('id', $value)->firstOrFail();
        });

        Route::bind('jdih', function (string $value) {
            return Link::where('id', $value)->firstOrFail();
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
