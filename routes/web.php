<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', 'AuthController@login');
Route::get('login/sso', 'AuthController@sso');
Route::match(['get', 'post'], 'register', 'AuthController@register');
Route::get('register-success', 'AuthController@registerSuccess');
Route::get('logout', 'AuthController@logout');
Route::get('auth/check-login', 'AuthController@checkLogin');

Route::prefix('otp')->group(function() {
    Route::get('telegram', 'OtpController@showOtpTelegram');
    Route::get('/', 'OtpController@showVerification');
    Route::get('verify', 'OtpController@showInputVerification');
    Route::post('send', 'OtpController@sendOtpTelegram');
    Route::post('verify', 'OtpController@validateOtp');
});


Route::middleware('auth.login')->group(function () {
    Route::get('/', 'DashboardController@index');
    
    Route::prefix('panel')->group(function () {   
        Route::get('dashboard', 'DashboardController@index');

        Route::prefix('select2')->group(function(){
            Route::post('user', 'Select2Controller@getUser');
            Route::post('olt', 'Select2Controller@getOlt');
        });

        Route::prefix('user')->group(function () {   
            Route::get('/', 'UserController@index');
            Route::post('datatable', 'UserController@datatable');
            Route::post('store', 'UserController@store');
            Route::get('show/{id}', 'UserController@show');
            Route::get('setting', 'UserController@setting');
            Route::post('activation', 'UserController@activation');
            Route::post('deactive', 'UserController@deactive');
        });

        Route::prefix('configuration')->group(function () {   
            Route::get('/', 'ConfigurationController@index');
            Route::get('form', 'ConfigurationController@form');
            Route::get('config-order', 'ConfigurationController@configOrder');
            Route::get('config-metro', 'ConfigurationController@configMetro');
            Route::get('config-gpon', 'ConfigurationController@configGpon');
            Route::get('config-ont', 'ConfigurationController@configOnt');
            Route::get('config-review', 'ConfigurationController@configReview');
            Route::post('datatable', 'ConfigurationController@datatable');
        });

        Route::prefix('logs')->group(function () {   
            Route::get('/', 'LogController@index');
            Route::post('datatable', 'LogController@datatable');
        });

        Route::prefix('dba-profile')->group(function () {   
            Route::post('store', 'DbaProfileController@store');
            Route::get('show/{id}', 'DbaProfileController@show');
            Route::post('delete/{id}', 'DbaProfileController@delete');
        });

        Route::prefix('gpon')->group(function () {   
            Route::get('/', 'GponController@index');
            Route::post('datatable', 'GponController@datatable');
        });

        Route::prefix('metro')->group(function () {   
            Route::get('/', 'MetroController@index');
            Route::post('datatable', 'Metroontroller@datatable');
        });

        Route::prefix('traffic-table')->group(function () {   
            Route::get('show/{id}', 'TrafficTableController@show');
        });

        Route::prefix('ont')->group(function () {   
            Route::get('register/{id}', 'OntController@register');
            Route::get('show/{id}', 'OntController@show');
        });

        Route::prefix('vlan')->group(function () {   
            Route::get('show/{id}', 'VlanController@show');
        });

        Route::prefix('service-port')->group(function () {   
            Route::get('show/{id}', 'ServicePortController@show');
        });

        Route::prefix('metro')->group(function () {   
            Route::get('/', 'MetroController@index');
            Route::post('datatable', 'MetroController@datatable');
            Route::post('store', 'MetroController@store');
        });

        Route::prefix('olt-site')->group(function () {   
            Route::get('/', 'OltSiteController@index');
            Route::post('datatable', 'OltSiteController@datatable');
            Route::post('store', 'OltSiteController@store');
        });

        Route::prefix('order')->group(function () {   
            Route::get('/', 'OrderController@index');
            Route::post('datatable', 'OrderController@datatable');
            Route::post('store', 'OrderController@store');
        });

        
    });
});
