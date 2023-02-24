<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\View\Composers\AsideComposer;

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

        View::composer('jdih.legislation.aside', AsideComposer::class);
        View::composer('jdih.post.aside', AsideComposer::class);
    }
}
