<?php
use Modules\Admin\Http\Controllers\AdminController;

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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');
    Route::get('/login', 'AdminController@login')->name('admin.login');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    Route::post('/loginSubmit', 'AdminController@loginSubmit')->name('admin.loginSubmit');
    
});

Route::group(['prefix' => 'admin',  'middleware' => 'loggedinCheck'], function()
{
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    
    ########## USERS SECTIONS STARTS HERE #####################
    Route::get('/users', 'UserController@index')->name('admin.user');
    Route::get('/users/add', 'UserController@add')->name('admin.user_add');
    Route::post('/users/create_user', 'UserController@create_user')->name('admin.create_user');
    Route::get('/users/edit/{id}', 'UserController@edit')->name('admin.user_edit');
    Route::post('/users/update_user/{id}', 'UserController@update_user')->name('admin.update_user');
    Route::post('/users/user_delete/{id}', 'UserController@user_delete')->name('admin.user_delete');
    ########## USERS SECTIONS ENDS HERE #####################

    ########## ROLES SECTIONS STARTS HERE #####################
    Route::get('/roles', 'RoleController@index')->name('admin.role');
    Route::get('/roles/add', 'RoleController@add')->name('admin.role_add');
    Route::post('/roles/create_role', 'RoleController@create_role')->name('admin.create_role');
    Route::get('/roles/edit/{id}', 'RoleController@edit')->name('admin.role_edit');
    Route::post('/roles/update_user/{id}', 'RoleController@update_role')->name('admin.update_role');
    Route::post('/roles/role_delete/{id}', 'RoleController@role_delete')->name('admin.role_delete');
    ########## ROLES SECTIONS ENDS HERE #####################


    ########## STATES SECTIONS STARTS HERE #####################
    Route::get('/states', 'StateController@index')->name('admin.state');
    Route::get('/states/add', 'StateController@add')->name('admin.state_add');
    Route::post('/states/create_state', 'StateController@create_state')->name('admin.create_state');
    Route::get('/states/edit/{id}', 'StateController@edit')->name('admin.state_edit');
    Route::post('/states/update_state/{id}', 'StateController@update_state')->name('admin.update_state');
    Route::post('/states/state_delete/{id}', 'StateController@state_delete')->name('admin.state_delete');
    ########## STATES SECTIONS ENDS HERE #####################

    ########## CITIES SECTIONS STARTS HERE #####################
    Route::get('/cities', 'CityController@index')->name('admin.city');
    Route::get('/cities/add', 'CityController@add')->name('admin.city_add');
    Route::post('/cities/create_city', 'CityController@create_city')->name('admin.create_city');
    Route::get('/cities/edit/{id}', 'CityController@edit')->name('admin.city_edit');
    Route::post('/cities/update_city/{id}', 'CityController@update_city')->name('admin.update_city');
    Route::post('/cities/city_delete/{id}', 'CityController@city_delete')->name('admin.city_delete');
    ########## CITIES SECTIONS ENDS HERE #####################
});
