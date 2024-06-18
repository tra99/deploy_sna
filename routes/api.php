<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */



    //============>>  Auth
    Route::group(['prefix' => 'auth'], function () {
        require(__DIR__ . '/api/auth.php');
    });

     //============>>  Site
     Route::group(['prefix' => 'site'], function () {
        require(__DIR__ . '/api/site/site.php');
    });

    //============>>  Authenticated
    Route::group(['prefix' => 'admin', 'middleware' => ['jwt.verify', 'admin.check']], function () {

        //============>>  Dashboard
        require(__DIR__ . '/api/admin/dashboard.php');

        //============>>  POS
        require(__DIR__ . '/api/admin/pos.php');

        //============>>  Sale
        require(__DIR__ . '/api/admin/sale.php');

        //============>>  Product
        require(__DIR__ . '/api/admin/product.php');

        //============>>  User
        require(__DIR__ . '/api/admin/user.php');
        //============>>  Customer
        require(__DIR__ . '/api/admin/customer.php');

        //============>> My Profile
        require(__DIR__ . '/api/admin/myprofile.php');

        // ===========>> Print
        Route::group(['prefix' => 'print'], function () {
            require(__DIR__ . '/api/admin/printpdf.php');
        });
    });
