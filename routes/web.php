<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    // Route::get('/', 'login')->name('login');
    // Route::post('/loginSubmit', 'loginSubmit')->name('login.submit');
    // Route::get('/user-forgot-password', 'forgotPassword')->name('user-forgot-password');
    // Route::post('/forgotPasswordSubmit', 'forgotPasswordSubmit')->name('forgotPasswordSubmit');
});