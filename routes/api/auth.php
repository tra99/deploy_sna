<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login',                   [AuthController::class, 'login']);
Route::post('/register',                [AuthController::class, 'register']);
Route::post('/verify',                  [AuthController::class, 'verify']);
Route::post('/sendOTP',                  [AuthController::class, 'sendOTP']);
Route::post('/forgotPassword',          [AuthController::class, 'forgotPassword']);
// Route::post('/refresh',                 [AuthController::class, 'refresh']);
