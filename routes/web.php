<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\StripeCheckout2Controller;
use App\Http\Controllers\StripeCheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    header('Turbolinks-location: dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('checkout', [StripeCheckoutController::class, 'create']);
Route::get('paymentIntent', [StripeCheckoutController::class, 'paymentIntent']);

//GRAFIKART
Route::get('stripe/pay', [StripeCheckout2Controller::class, 'paymentIntent']);
Route::match(['get', 'post'],'stripe/webhook', [StripeCheckout2Controller::class, 'webhook']);
//ENDGRAFIKART

Route::get('shoppingCart', ShoppingCartController::class);
Route::get('products', [ProductController::class, 'index'])->name('products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
