<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
 
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }
 
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::share([
            'appName' => 'JDIH Admin',      
            'appLogoUrl' => asset('assets/admin/images/logo_icon.svg'),
            'company' => 'CV. Balemedia',
            'companyUrl' => 'https://balemedia.id',
        ]);
    }
}