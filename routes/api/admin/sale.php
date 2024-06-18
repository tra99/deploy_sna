<?php

use App\Http\Controllers\Admin\Sale\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/sales',            [OrderController::class, 'listing']);
Route::delete('/sales/{id}',    [OrderController::class, 'delete']);
Route::get('/sales/takeAction/{id}',       [OrderController::class, 'takeAction']);
