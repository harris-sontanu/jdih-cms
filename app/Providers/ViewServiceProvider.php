<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\Visitor;
use App\Models\Post;
use App\View\Composers\FooterComposer;

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

        View::composer(
            ['jdih.layouts.footer', 'jdih.legislation.leftbar'],
            FooterComposer::class
        );

        View::composer('jdih.layouts.footer', function ($view) {
            $todayVisitor = Visitor::countDaily()->get()->count();
            $yesterdayVisitor = Visitor::countDaily(1)->get()->count();
            $lastWeekVisitor = Visitor::countWeekly()->get()->count();
            $lastMonthVisitor = Visitor::countMonthly()->get()->count();
            $allVisitor = Visitor::countAll()->get()->count();

            $welcome = Post::whereSlug('selamat-datang')->first();

            return $view->with('todayVisitor', $todayVisitor)
                ->with('yesterdayVisitor', $yesterdayVisitor)
                ->with('lastWeekVisitor', $lastWeekVisitor)
                ->with('lastMonthVisitor', $lastMonthVisitor)
                ->with('allVisitor', $allVisitor)
                ->with('welcome', $welcome);
        });
    }
}
