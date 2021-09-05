<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Enums\Roles;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;

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

Route::middleware(['auth'])->group(function ()
{
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/dashboard', function ()
    {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => ['role:' . Roles::seller()->value ]], function ()
    {
        Route::resource('products', ProductController::class);
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    });

    Route::group(['middleware' => ['role:' . Roles::customer()->label ]], function ()
    {
        Route::get('shop',                      [ShopController::class, 'index'])->name('shop');
        Route::get('cart',                      [ShopController::class, 'cart'])->name('cart');
        Route::post('shop/add-to-cart',         [ShopController::class, 'addToCart'])->name('shop.add-to-cart');
        Route::get('shop/clear-cart',           [ShopController::class, 'clear'])->name('shop.clear-cart');
        Route::post('orders/place',             [OrderController::class, 'placeOrder'])->name('orders.place');
        Route::get('orders/{id}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    });


});


require __DIR__.'/auth.php';
