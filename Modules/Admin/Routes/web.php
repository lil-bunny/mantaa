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
    Route::post('/roles/update_role/{id}', 'RoleController@update_role')->name('admin.update_role');
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

    ########## MENUS SECTIONS STARTS HERE #####################
    Route::get('/menus', 'MenuController@index')->name('admin.menu');
    Route::get('/menus/add', 'MenuController@add')->name('admin.menu_add');
    Route::post('/menus/create_menu', 'MenuController@create_menu')->name('admin.create_menu');
    Route::get('/menus/edit/{id}', 'MenuController@edit')->name('admin.menu_edit');
    Route::post('/menus/update_menu/{id}', 'MenuController@update_menu')->name('admin.update_menu');
    Route::post('/menus/menu_delete/{id}', 'MenuController@menu_delete')->name('admin.menu_delete');
    ########## MENUS SECTIONS ENDS HERE #####################

    ########## AREA SECTIONS STARTS HERE #####################
    Route::get('/areas', 'AreaController@index')->name('admin.area');
    Route::get('/areas/add', 'AreaController@add')->name('admin.area_add');
    Route::post('/areas/create_area', 'AreaController@create_area')->name('admin.create_area');
    Route::get('/areas/edit/{id}', 'AreaController@edit')->name('admin.area_edit');
    Route::post('/areas/update_area/{id}', 'AreaController@update_area')->name('admin.update_area');
    Route::post('/areas/area_delete/{id}', 'AreaController@area_delete')->name('admin.area_delete');
    Route::get('/campaign_generate', 'AreaController@campaign_generate_pdf')->name('admin.campaign_generate');
    Route::get('/areas/fetch_poi/{id}', 'AreaController@fetch_poi')->name('admin.fetch_poi');
    Route::post('/areas/add_poi', 'AreaController@add_poi')->name('admin.add_poi');
    Route::get('/areas/view_poi/{id}', 'AreaController@view_poi')->name('admin.view_poi');
    ########## AREA SECTIONS ENDS HERE #####################

    ########## FEEDBACKS SECTIONS STARTS HERE #####################
    Route::get('/feedbacks', 'FeedbackController@index')->name('admin.feedback');
    Route::get('/feedbacks/edit/{id}', 'FeedbackController@edit')->name('admin.feedback_edit');
    Route::post('/feedbacks/update_feedback/{id}', 'FeedbackController@update_feedback')->name('admin.update_feedback');
    Route::post('/feedbacks/feedback_delete/{id}', 'FeedbackController@feedback_delete')->name('admin.feedback_delete');
    ########## FEEDBACKS SECTIONS ENDS HERE #####################

    ########## CONNECT REQUESTS SECTIONS STARTS HERE #####################
    Route::get('/connect_requests', 'ConnectRequestController@index')->name('admin.connect_request');
    Route::get('/connect_requests/view/{id}', 'ConnectRequestController@view')->name('admin.connect_request_view');
    Route::post('/connect_requests/connect_request_delete/{id}', 'ConnectRequestController@connect_request_delete')->name('admin.connect_request_delete');
    ########## CONNECT REQUESTS SECTIONS ENDS HERE #####################

    ########## DOWNLOAD SECTIONS STARTS HERE #####################
    Route::get('/downloads', 'DownloadController@index')->name('admin.download');
    Route::get('/downloads/view/{id}', 'DownloadController@view')->name('admin.download_view');
    Route::post('/downloads/download_delete/{id}', 'DownloadController@download_delete')->name('admin.download_delete');
    ########## DOWNLOAD SECTIONS STARTS HERE #####################

    ########## CAMPAIGN SECTIONS STARTS HERE #####################
    Route::get('/campaign_search', 'CampaignController@index')->name('admin.campaign_search');
    Route::post('/review_campaign', 'CampaignController@review_campaign')->name('admin.review_campaign');
    ########## CAMPAIGN SECTIONS ENDS HERE #####################

    ########## SETTINGS SECTIONS STARTS HERE #####################
    Route::get('/settings', 'SettingController@index')->name('admin.setting');
    ########## SETTINGS SECTIONS STARTS HERE #####################
});
