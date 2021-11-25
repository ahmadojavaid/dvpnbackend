<?php

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

//public routes
//authentication routes
Route::get('/login', 'Auth\AuthController@loginView');
Route::get('/reset-password', 'Auth\AuthController@resetPasswordView');

Route::post('/user-login', 'Auth\AuthController@userLogin');

//generic reset password routes
Route::get('/reset-password/{id}', 'Auth\PasswordResetController@validateEmailToken');
Route::post('/forgot-email-request', 'Auth\PasswordResetController@validateSendEmail');
Route::post('/change-user-password', 'Auth\PasswordResetController@changePassword');

//private routes

Route::group(['middleware' => 'UserAuth'], function () {

    Route::get('/', 'DashboardController@loadView');
    Route::get('/logout', 'Auth\AuthController@logout');
    Route::get('/deactivate-user/{id}', 'DashboardController@deactivateUser');

});


