<?php

use App\Http\Controllers\Api\JdihnController;
use App\Http\Resources\LawResource;
use App\Http\Resources\MonographResource;
use App\Models\Legislation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(JdihnController::class)->group(function () {
    Route::get('/produk-hukum/peraturan', 'index');
    Route::get('/produk-hukum/peraturan/{id}', 'show');
});

Route::get('/laws', function (Request $request) {
    return LawResource::collection(Legislation::ofType(1)
        ->search($request)
        ->sorted()
        ->paginate()
    );
});

Route::get('/monographs', function (Request $request) {
    return MonographResource::collection(Legislation::ofType(2)
        ->search($request)
        ->sorted()
        ->paginate()
    );
});