<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaDetailsController;

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
    ########## AREA SECTIONS STARTS HERE #####################
    Route::get('/area-details/{id}', 'App\Http\Controllers\AreaDetailsController@index')->name('area-details');
    ########## AREA ENDS HERE #####################
});



