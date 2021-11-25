<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['json.response']], function () {

    // public routes
    //authentication
    Route::post('/login', 'Api\AuthController@userLogin')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register.api');

    //forgot Password
    Route::post('/forgot-password', 'Api\PasswordResetController@generateForgotPassCode')->name('forgot-password.api');
    Route::post('/validate-code', 'Api\PasswordResetController@validateCode')->name('validate-code.api');
    Route::post('/update-password', 'Api\PasswordResetController@updateForgotPassword')->name('update-password.api');


    // private routes
    Route::middleware('auth:api')->group(function () {

        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
        Route::get('/resend-verify-code', 'Api\AuthController@resendVerificationCode');
        Route::post('/verify-account', 'Api\AuthController@verifyAccount');

        //receipt validation
        Route::post('/validate-receipt', 'Api\PaymentcheckController@validateAppPurchaseReceipt');

        //payment check API's
        Route::post('/update-payment-status', 'Api\PaymentcheckController@updatepaymentstatus');
        Route::get('/check-payment-status', 'Api\PaymentcheckController@checkpaymentstatus');

        //profile Routes
        Route::post('/change-password', 'Api\AuthController@changeUserPassword');
        Route::get('/user-profile', 'Api\ProfileController@getProfileDetails');
        Route::post('/update-profile', 'Api\ProfileController@updateProfile');

    });

});
