<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        $settings['appLogoUrl'] = isset($settings['appLogo'])
            ? (Storage::disk('public')->exists($settings['appLogo'])
                ? Storage::url($settings['appLogo'])
                : '/assets/jembrana/img/app-logo.png')
            : '/assets/jembrana/img/app-logo.png';

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
