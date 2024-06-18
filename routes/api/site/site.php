<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CustomerController;


Route::get('/home',                            [HomeController::class, 'home']);

Route::get('/shop/products',                   [ShopController::class, 'getProducts']);
Route::get('/shop/products/{id}',              [ShopController::class, 'viewProduct']);

Route::group(['prefix' => 'customer', 'middleware' => ['jwt.verify']], function () {
    
    Route::post('/checkout',                    [CustomerController::class, 'checkoutOrder']);
    Route::get('/history',                      [CustomerController::class, 'getOrderHistory']);
});

