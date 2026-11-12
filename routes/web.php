<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::post('/paypal/create-order', [PayPalController::class, 'createOrder'])->name('paypal.create');
Route::post('/paypal/capture-order', [PayPalController::class, 'captureOrder'])->name('paypal.capture');

Route::get('/checkout', function () {
    return view('checkout');
});