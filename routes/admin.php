<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Http\Controllers\Admin\Legislation\CategoryController;
use App\Http\Controllers\Admin\Legislation\DocumentController;
use App\Http\Controllers\Admin\Legislation\LawController;
use App\Http\Controllers\Admin\Legislation\MonographController;
use App\Http\Controllers\Admin\Legislation\ArticleController;
use App\Http\Controllers\Admin\Legislation\JudgmentController;
use App\Http\Controllers\Admin\Legislation\MatterController;
use App\Http\Controllers\Admin\Legislation\InstituteController;
use App\Http\Controllers\Admin\Legislation\FieldController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Employee\GroupController;
use App\Http\Controllers\Admin\Media\FileController;
use App\Http\Controllers\Admin\Media\ImageController;
use App\Http\Controllers\Admin\Media\MediaController;
use App\Http\Controllers\Admin\Link\LinkController;
use App\Http\Controllers\Admin\Link\YoutubeController;
use App\Http\Controllers\Admin\Link\BannerController;
use App\Http\Controllers\Admin\Link\JdihController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\QuestionnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisitorController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::redirect('/', '/admin/dashboard');

Route::name('admin.')->group(function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::view('/login', 'admin.auth.login')
        ->middleware('guest:admin')
        ->name('login');
    }

    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $limiter ? 'throttle:'.$limiter : null,
        ]));


    Route::middleware('auth:admin')->group(function() {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/user/export/{format}', [UserController::class, 'export'])->name('user.export');
        Route::resource('user', UserController::class)->withTrashed();
        Route::controller(UserController::class)->group(function () {
            Route::post('/user/trigger', 'trigger')->name('user.trigger');
            Route::put('/user/{user}/restore', 'restore')->withTrashed()->name('user.restore');
            Route::delete('/user/{user}/force-destroy', 'forceDestroy')->withTrashed()->name('user.force-destroy');
            Route::put('/user/{user}/delete-avatar', 'deleteAvatar')->name('user.delete-avatar');
            Route::put('/user/{user}/set-new-password', 'setNewPassword')->name('user.set-new-password');
        });

        Route::name('legislation.')->group(function () {
            Route::resource('/legislation/category', CategoryController::class)->except(['create', 'show']);
            Route::controller(CategoryController::class)->group(function () {
                Route::post('/legislation/category/order-update', 'orderUpdate')->name('category.order-update');
            });

            Route::post('/legislation/matter/select-options', [MatterController::class, 'selectOptions'])->name('matter.select-options');
            Route::resource('/legislation/matter', MatterController::class);

            Route::get('/legislation/law/export/{format}', [LawController::class, 'export'])->name('law.export');
            Route::resource('/legislation/law', LawController::class);
            Route::controller(LawController::class)->group(function () {
                Route::post('/legislation/law/trigger', 'trigger')->name('law.trigger');
                Route::put('/legislation/law/{law}/restore', 'restore')->name('law.restore');
                Route::delete('/legislation/law/{law}/force-destroy', 'forceDestroy')->name('law.force-destroy');
                Route::post('/legislation/law/status-relationship-row', 'statusRelationshipRow')->name('law.status-relationship-row');
                Route::post('/legislation/law/law-relationship-row', 'lawRelationshipRow')->name('law.law-relationship-row');
                Route::post('/legislation/law/doc-relationship-row', 'docRelationshipRow')->name('law.doc-relationship-row');
                Route::delete('/legislation/law/{law}/status-relationship-destroy', 'statusRelationshipDestroy')->name('law.status-relationship-destroy');
                Route::delete('/legislation/law/{law}/law-relationship-destroy', 'lawRelationshipDestroy')->name('law.law-relationship-destroy');
                Route::delete('/legislation/law/{law}/doc-relationship-destroy', 'docRelationshipDestroy')->name('law.doc-relationship-destroy');
            });

            Route::get('/legislation/monograph/export/{format}', [MonographController::class, 'export'])->name('monograph.export');
            Route::resource('/legislation/monograph', MonographController::class);
            Route::controller(MonographController::class)->group(function () {
                Route::post('/legislation/monograph/trigger', 'trigger')->name('monograph.trigger');
                Route::put('/legislation/monograph/{monograph}/restore', 'restore')->name('monograph.restore');
                Route::delete('/legislation/monograph/{monograph}/force-destroy', 'forceDestroy')->name('monograph.force-destroy');
            });

            Route::get('/legislation/article/export/{format}', [ArticleController::class, 'export'])->name('article.export');
            Route::resource('/legislation/article', ArticleController::class);
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/legislation/article/trigger', 'trigger')->name('article.trigger');
                Route::put('/legislation/article/{article}/restore', 'restore')->name('article.restore');
                Route::delete('/legislation/article/{article}/force-destroy', 'forceDestroy')->name('article.force-destroy');
            });

            Route::get('/legislation/judgment/export/{format}', [JudgmentController::class, 'export'])->name('judgment.export');
            Route::resource('/legislation/judgment', JudgmentController::class);
            Route::controller(JudgmentController::class)->group(function () {
                Route::post('/legislation/judgment/trigger', 'trigger')->name('judgment.trigger');
                Route::put('/legislation/judgment/{judgment}/restore', 'restore')->name('judgment.restore');
                Route::delete('/legislation/judgment/{judgment}/force-destroy', 'forceDestroy')->name('judgment.force-destroy');
            });

            Route::delete('/legislation/document/{id}', DocumentController::class)->name('document.destroy');

            Route::post('/legislation/institute/select-options', [InstituteController::class, 'selectOptions'])->name('institute.select-options');
            Route::resource('/legislation/institute', InstituteController::class);

            Route::post('/legislation/field/select-options', [FieldController::class, 'selectOptions'])->name('field.select-options');
            Route::resource('/legislation/field', FieldController::class);

            Route::controller(LegislationController::class)->group(function () {
                Route::get('/legislation/search', 'search')->name('search');
                Route::get('/legislation/log', 'log')->name('log');
                Route::get('/legislation/statistic', 'statistic')->name('statistic');
                Route::post('/legislation/law-yearly-column-chart', 'lawYearlyColumnChart')->name('law-yearly-column-chart');
                Route::post('/legislation/law-monthly-column-chart', 'lawMonthlyColumnChart')->name('law-monthly-column-chart');
                Route::post('/legislation/law-status-column-chart', 'lawStatusColumnChart')->name('law-status-column-chart');
                Route::post('/legislation/statistic/filter', 'legislationFilter')->name('legislation-filter');
                Route::post('/legislation/most-viewed-chart', 'mostViewedChart')->name('most-viewed-chart');
                Route::post('/legislation/most-download-chart', 'mostDownloadChart')->name('most-download-chart');
            });
        });

        Route::resource('/news', NewsController::class)->withTrashed();
        Route::controller(NewsController::class)->group(function () {
            Route::post('/news/trigger', 'trigger')->withTrashed()->name('news.trigger');
            Route::put('/news/{news}/restore', 'restore')->withTrashed()->name('news.restore');
            Route::delete('/news/{news}/force-destroy', 'forceDestroy')->withTrashed()->name('news.force-destroy');
        });

        Route::controller(TaxonomyController::class)->group(function () {
            Route::post('/taxonomy/{type}/select-options','selectOptions')->name('taxonomy.select-options');
            Route::get('/taxonomy/{type}', 'index')->name('taxonomy.index');
            Route::post('/taxonomy/{type}', 'store')->name('taxonomy.store');
            Route::get('/taxonomy/{taxonomy}/edit', 'edit')->name('taxonomy.edit');
            Route::put('/taxonomy/{taxonomy}/update', 'update')->name('taxonomy.update');
            Route::delete('/taxonomy/{taxonomy}/destroy', 'destroy')->name('taxonomy.destroy');
        });

        Route::controller(VisitorController::class)->group(function () {
            Route::get('/visitor', 'index')->name('visitor');
            Route::post('/visitor/bar-chart', 'barChart')->name('visitor.bar-chart');
            Route::post('/visitor/chart', 'chart')->name('visitor.chart');
            Route::post('/visitor/browser-chart', 'browserChart')->name('visitor.browser-chart');
            Route::post('/visitor/download-chart', 'downloadChart')->name('visitor.download-chart');
        });

        Route::name('employee.')->group(function () {
            Route::controller(EmployeeController::class)->group(function () {
                Route::post('/employee/trigger', 'trigger')->name('trigger');
                Route::post('/employee/order-update', 'orderUpdate')->name('order-update');
                Route::put('/employee/{employee}/delete-avatar', 'deleteAvatar')->name('delete-avatar');
            });

            Route::resource('/employee/group', GroupController::class)->except([
                'create', 'show'
            ]);

        });
        Route::resource('/employee', EmployeeController::class);

        Route::resource('/page', PageController::class)->withTrashed();
        Route::controller(PageController::class)->group(function () {
            Route::post('/page/trigger', 'trigger')->withTrashed()
                ->name('page.trigger');
            Route::post('/page/order-update', 'orderUpdate')
                ->name('page.order-update');
            Route::put('/page/{page}/restore', 'restore')->withTrashed()
                ->name('page.restore');
            Route::delete('/page/{page}/force-destroy', 'forceDestroy')->withTrashed()
                ->name('page.force-destroy');
            Route::delete('/page/{page}/delete-cover', 'deleteCover')->withTrashed()
                ->name('page.delete-cover');
        });

        Route::name('media.')->group(function () {
            Route::resource('/media/image', ImageController::class)->except(['show', 'create']);
            Route::resource('/media/file', FileController::class)->except(['show', 'create']);
            Route::post('/media/trigger', [MediaController::class, 'trigger'])->name('trigger');
        });

        Route::name('link.')->group(function () {
            Route::resource('/link/youtube', YoutubeController::class)->except(['show', 'create']);
            Route::resource('/link/banner', BannerController::class)->except(['show', 'create']);
            Route::resource('/link/jdih', JdihController::class)->except(['show', 'create']);

            Route::controller(LinkController::class)->group(function () {
                Route::post('/link/trigger', 'trigger')->name('trigger');
                Route::post('/link/order-update', 'orderUpdate')->name('order-update');
            });
        });

        Route::controller(QuestionnerController::class)->group(function () {
            Route::get('/questionner', 'index')->name('questionner.index');
            Route::put('/questionner/update', 'update')->name('questionner.update');
            Route::post('/questionner/question/store', 'store')->name('questionner.question.store');
            Route::get('/questionner/question/{question}/edit', 'edit')->name('questionner.question.edit');
            Route::put('/questionner/question/{question}/update', 'update')->name('questionner.question.update');
            Route::delete('/questionner/question/{question}/destroy', 'destroyQuestion')->name('questionner.question.delete');
            Route::delete('/questionner/answer/{answer}/destroy', 'destroyAnswer')->name('questionner.answer.delete');
            Route::get('/questionner/statistic', 'statistic')->name('questionner.statistic');
            Route::post('/questionner/vote-chart', 'voteChart')->name('questionner.vote-chart');
            Route::post('/questionner/vote-line-chart', 'voteLineChart')->name('questionner.vote-line-chart');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('/setting', 'index')->name('setting.index');
            Route::put('/setting', 'update')->name('setting.update');
            Route::put('/setting/questionner', 'questionner')->name('setting.questionner');
        });
    });
});
