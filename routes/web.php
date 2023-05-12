<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaDetailsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('frontend.home');
    Route::get('/login', 'login')->name('frontend.login');
    Route::get('/logout', 'logout')->name('frontend.logout');
    Route::post('/loginSubmit', 'loginSubmit')->name('frontend.loginSubmit');
    Route::get('/register', 'register')->name('frontend.register');
    Route::post('/registerSubmit', 'registerSubmit')->name('frontend.registerSubmit');
});

Route::group(['middleware' => 'customerloggedinCheck'], function()
{
    ########## AREA DETAILS SECTIONS STARTS HERE #####################
    Route::get('/area-details/{id}', 'App\Http\Controllers\AreaDetailsController@index')->name('area-details');
    Route::post('/connect-request', 'App\Http\Controllers\AreaDetailsController@connect_request')->name('frontend.connect_request');
    Route::post('/dload-file', 'App\Http\Controllers\AreaDetailsController@dload_file')->name('frontend.dload_file');
    ########## AREA DETAILS ENDS HERE #####################
    
    ########## AREA DETAILS SECTIONS STARTS HERE #####################
    Route::post('/feedbackSubmit/{id}', 'App\Http\Controllers\FeedbackController@feedbackSubmit')->name('frontend.feedbackSubmit');
    ########## AREA DETAILS ENDS HERE #####################
});

########## AREA SEARCH AND LISTING SECTIONS STARTS HERE #####################
Route::get('/autocomplete-search', 'App\Http\Controllers\AreaDetailsController@autocompleteSearch')->name('frontend.autocompleteSearch');
Route::get('/area-search', 'App\Http\Controllers\AreaDetailsController@areaSearch')->name('frontend.areaSearch');
########## AREA SEARCH AND LISTING ENDS HERE #####################

########## FORGET PASSWORD SECTIONS STARTS HERE #####################
Route::get('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@showForgetPasswordForm')->name('frontend.showForgetPasswordForm');
Route::post('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@submitForgetPasswordForm')->name('frontend.submitForgetPasswordForm'); 

Route::get('/reset-password/{token}', 'App\Http\Controllers\ForgotPasswordController@showResetPasswordForm')->name('frontend.showResetPasswordForm');
Route::post('/reset-password', 'App\Http\Controllers\ForgotPasswordController@submitResetPasswordForm')->name('frontend.submitResetPasswordForm');
########## FORGET PASSWORD SECTIONS END HERE #####################

########## GOOGLE LOGIN SECTIONS STARTS HERE #####################
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', 'App\Http\Controllers\GoogleController@loginWithGoogle')->name('login');
    Route::any('callback', 'App\Http\Controllers\GoogleController@callbackFromGoogle')->name('callback');
});
########## GOOGLE LOGIN SECTIONS ENDS HERE #####################

########## EDIT USER SECTIONS STARTS HERE #####################
Route::get('/users/edit/', 'App\Http\Controllers\HomeController@edit')->name('frontend.user_edit');
Route::post('/users/update_user/', 'App\Http\Controllers\HomeController@update_user')->name('frontend.update_user');
########## EDIT USER SECTIONS ENDS HERE #####################