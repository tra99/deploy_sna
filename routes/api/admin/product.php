<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductTypeController;
use App\Http\Controllers\Admin\Product\ProductBrandController;
use App\Http\Controllers\Admin\Product\ProductCategoryController;

Route::get('/products',         [ProductController::class, 'listing']); // Read Many Records
Route::get('/products/{id}',    [ProductController::class, 'view']);    // Read 1 Record
Route::post('/products',        [ProductController::class, 'create']);
Route::post('/products/{id}',   [ProductController::class, 'update']);  // Update
Route::delete('/products/{id}', [ProductController::class, 'delete']);
Route::post('/products/stock/{id}',   [ProductController::class, 'add_stock']);  


Route::group(['prefix' => 'product'], function () {

    // ===========================================================================>> Product Types
    Route::get('/types',            [ProductTypeController::class, 'listing']);
    Route::post('/types',           [ProductTypeController::class, 'create']);
    Route::post('/types/{id}',      [ProductTypeController::class, 'update']);
    Route::delete('/types/{id}',    [ProductTypeController::class, 'delete']);

    // ===========================================================================>> Product Brand
    Route::get('/brands',            [ProductBrandController::class, 'listing']);
    Route::post('/brands',           [ProductBrandController::class, 'create']);
    Route::post('/brands/{id}',      [ProductBrandController::class, 'update']);
    Route::delete('/brands/{id}',    [ProductBrandController::class, 'delete']);

    // ===========================================================================>> Product Category
    Route::get('/categories',            [ProductCategoryController::class, 'listing']);
    Route::post('/categories',           [ProductCategoryController::class, 'create']);
    Route::post('/categories/{id}',      [ProductCategoryController::class, 'update']);
    Route::delete('/categories/{id}',    [ProductCategoryController::class, 'delete']);
});
