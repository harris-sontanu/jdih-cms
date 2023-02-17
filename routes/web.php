<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jdih\HomepageController;
use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Http\Controllers\Jdih\Legislation\LawController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomepageController::class)
    ->name('homepage');

Route::post('/legislation/law-yearly-column-chart', [LegislationController::class, 'lawYearlyColumnChart']);

Route::name('legislation.')->group(function () {

    Route::controller(LegislationController::class)->group(function () {
        Route::post('/legislation/category-options', 'categoryOptions')
            ->name('categoryOptions');
        Route::put('/legislation/download/{id}', 'download')
            ->name('download');
    });

    Route::controller(LawController::class)->group(function () {
        Route::get('/produk-hukum/peraturan-perundang-undangan', 'index')
            ->name('law.index');
        Route::get('/produk-hukum/peraturan-perundang-undangan/{category:slug}', 'category')
            ->name('law.category');
        Route::get('/produk-hukum/peraturan-perundang-undangan/{category:slug}/{legislation:slug}', 'show')
            ->name('law.show');
    });

});
