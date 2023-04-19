<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
 
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
        $settings = Setting::pluck('value', 'key')->toArray();

        $settings['appLogoUrl'] = isset($settings['appLogo'])
            ? (Storage::disk('public')->exists($settings['appLogo'])
                ? Storage::url($settings['appLogo'])
                : '/assets/admin/images/logo_icon.svg')
            : '/assets/admin/images/logo_icon.svg';

        $settings['jdihnLogoUrl'] = isset($settings['jdihnLogo'])
            ? (Storage::disk('public')->exists($settings['jdihnLogo'])
                ? Storage::url($settings['jdihnLogo'])
                : '/assets/admin/images/jdihn-logo-web.png')
            : '/assets/admin/images/jdihn-logo-web.png';

        $settings['fullAddress'] = implode(', ', [
            $settings['address'],
            $settings['city'],
            $settings['district'],
            $settings['regency'],
            $settings['province']
        ]);

        View::share($settings);
    }
}