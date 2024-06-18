<?php

use App\Http\Controllers\Admin\Customer\CustomerController;
use Illuminate\Support\Facades\Route;


Route::get('/customers', 						[CustomerController::class, 'listing']);
Route::get('/customers/{id}', 					[CustomerController::class, 'view']);
Route::post('/customers', 						[CustomerController::class, 'create']);
Route::post('/customers/{id}', 					[CustomerController::class, 'update']);
Route::post('/customers/block/{id}', 			[CustomerController::class, 'block']);
Route::delete('/customers/{id}', 				[CustomerController::class, 'delete']);
Route::post('/customers/{id}/change-password',  [CustomerController::class, 'changePassword']);
Route::group(['prefix' => 'customer'],function (){
    Route::get('/get-type',               [CustomerController::class, 'getType']);
});