<?php

use App\Http\Controllers\Api\CartController;
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

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('products/increase/{id}', [CartController::class, 'increase']);
    Route::get('products/decrease/{id}', [CartController::class, 'decrease']);

    Route::get('products/count', [CartController::class, 'count'])
        ->name('products.count');
    Route::apiResource('products', CartController::class);
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
