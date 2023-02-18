<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jdih\HomepageController;
use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Http\Controllers\Jdih\Legislation\LawController;
use App\Http\Controllers\Jdih\Legislation\MonographController;
use App\Http\Controllers\Jdih\Legislation\ArticleController;
use App\Http\Controllers\Jdih\Legislation\JudgmentController;

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
        Route::get('/produk-hukum', 'index')
            ->name('index');
    });

    Route::controller(LawController::class)->group(function () {
        Route::get('/produk-hukum/peraturan-perundang-undangan', 'index')
            ->name('law.index');
        Route::get('/produk-hukum/peraturan-perundang-undangan/{category:slug}', 'category')
            ->name('law.category');
        Route::get('/produk-hukum/peraturan-perundang-undangan/{category:slug}/{legislation:slug}', 'show')
            ->name('law.show');
    });

    Route::controller(MonographController::class)->group(function () {
        Route::get('/produk-hukum/monografi-hukum', 'index')
            ->name('monograph.index');
        Route::get('/produk-hukum/monografi-hukum/{category:slug}', 'category')
            ->name('monograph.category');
        Route::get('/produk-hukum/monografi-hukum/{category:slug}/{legislation:slug}', 'show')
            ->name('monograph.show');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::get('/produk-hukum/artikel-hukum', 'index')
            ->name('article.index');
        Route::get('/produk-hukum/artikel-hukum/{category:slug}', 'category')
            ->name('article.category');
        Route::get('/produk-hukum/artikel-hukum/{category:slug}/{legislation:slug}', 'show')
            ->name('article.show');
    });

    Route::controller(JudgmentController::class)->group(function () {
        Route::get('/produk-hukum/putusan-pengadilan', 'index')
            ->name('judgment.index');
        Route::get('/produk-hukum/putusan-pengadilan/{category:slug}', 'category')
            ->name('judgment.category');
        Route::get('/produk-hukum/putusan-pengadilan/{category:slug}/{legislation:slug}', 'show')
            ->name('judgment.show');
    });

});
