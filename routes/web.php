<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function ()
{
    return redirect('dashboard');
});
Route::get('admin', function ()
{
    return redirect('dashboard');
});

Route::get('/clear', function ()
{
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    Cache::forget('spatie.permission.cache');
    return 'cleared';
});

//LOGIN GROUP
Route::group(['namespace' => 'Admin', 'prefix' => '', 'middleware' => ['guest:admin', 'throttle:100,1']], function () {
    //LOGIN ROUTE
    Route::get('login', ['as' => 'login.view', 'uses' => 'LoginController@getLogin']);
    Route::post('login', ['as' => 'login.view', 'uses' => 'LoginController@postLogin']);
});

Route::group(['namespace' => 'Admin', 'prefix' => '', 'middleware' => ['web', 'auth:admin', 'throttle:100,1']], function () {
    Route::get('test', ['as' => 'test', 'uses' => 'TestController@getIndex']);

    //Dashboard Route
    Route::get('dashboard', ['as' => 'dashboard.view', 'uses' => 'DashboardController@getIndex']);
    Route::get('profile', ['as' => 'dashboard.profile', 'uses' => 'DashboardController@getProfile']);
    Route::post('profile', ['as' => 'dashboard.profile', 'uses' => 'DashboardController@postProfile']);
    Route::get('password', ['as' => 'dashboard.password', 'uses' => 'DashboardController@getPassword']);
    Route::post('password', ['as' => 'dashboard.password', 'uses' => 'DashboardController@postPassword']);

    //Setting Route
//        Route::get('settings', ['as' => 'settings.view', 'middleware' => ['permission:settings.view'], 'uses' => 'SettingsController@getIndex']);
//        Route::post('settings', ['as' => 'settings.view', 'middleware' => ['permission:settings.view'], 'uses' => 'SettingsController@postIndex']);
//

    //Users Route
    Route::get('users', ['as' => 'users.view', 'middleware' => ['permission:users.view|users.add|users.edit|users.delete|users.password'], 'uses' => 'UsersController@getIndex']);
    Route::get('users/list', ['as' => 'users.list', 'middleware' => ['permission:users.view|users.add|users.edit|users.delete|users.password'], 'uses' => 'UsersController@getList']);
    Route::get('users/add', ['as' => 'users.add', 'middleware' => ['permission:users.add'], 'uses' => 'UsersController@getAdd']);
    Route::post('users/add', ['as' => 'users.add', 'middleware' => ['permission:users.add'], 'uses' => 'UsersController@postAdd']);
    Route::get('users/edit/{id}', ['as' => 'users.edit', 'middleware' => ['permission:users.edit'], 'uses' => 'UsersController@getEdit']);
    Route::post('users/edit/{id}', ['as' => 'users.edit', 'middleware' => ['permission:users.edit'], 'uses' => 'UsersController@postEdit']);
    Route::get('users/password/{id}', ['as' => 'users.password', 'middleware' => ['permission:users.password'], 'uses' => 'UsersController@getPassword']);
    Route::post('users/password/{id}', ['as' => 'users.password', 'middleware' => ['permission:users.password'], 'uses' => 'UsersController@postPassword']);
    Route::get('users/delete/{id}', ['as' => 'users.delete', 'middleware' => ['permission:users.delete'], 'uses' => 'UsersController@getDelete']);
    Route::get('users/permissions/{id}', ['as' => 'users.permissions', 'middleware' => ['permission:users.permissions'], 'uses' =>'UsersController@getPermissions']);
    Route::post('users/permissions/{id}', ['as' => 'users.permissions', 'middleware' => ['permission:users.permissions'], 'uses' =>'UsersController@postPermissions']);




    // ROLES ROUTE
    Route::get('roles', ['as' => 'roles.view', 'middleware' => ['permission:roles.view|roles.add|roles.edit|roles.delete|roles.status|roles.permissions'], 'uses' => 'RolesController@getIndex']);
    Route::get('roles/list', ['as' => 'roles.list', 'middleware' => ['permission:roles.view|roles.add|roles.edit|roles.delete|roles.status|roles.permissions'], 'uses' => 'RolesController@getList']);
    Route::get('roles/add', ['as' => 'roles.add', 'middleware' => ['permission:roles.add'], 'uses' => 'RolesController@getAdd']);
    Route::post('roles/add', ['as' => 'roles.add', 'middleware' => ['permission:roles.add'], 'uses' => 'RolesController@postAdd']);
    Route::get('roles/edit/{id}', ['as' => 'roles.edit', 'middleware' => ['permission:roles.edit'], 'uses' => 'RolesController@getEdit']);
    Route::post('roles/edit/{id}', ['as' => 'roles.edit', 'middleware' => ['permission:roles.edit'], 'uses' => 'RolesController@postEdit']);
    Route::get('roles/delete/{id}', ['as' => 'roles.delete', 'middleware' => ['permission:roles.delete'], 'uses' => 'RolesController@getDelete']);
    Route::post('roles/status', ['as' => 'roles.status', 'middleware' => ['permission:roles.status'], 'uses' => 'RolesController@postStatus']);
    Route::get('roles/permissions/{id}', ['as' => 'roles.permissions', 'middleware' => ['permission:roles.permissions'], 'uses' =>'RolesController@getPermissions']);
    Route::post('roles/permissions/{id}', ['as' => 'roles.permissions', 'middleware' => ['permission:roles.permissions'], 'uses' =>'RolesController@postPermissions']);

    //Logout Route
    Route::get('logout', ['as' => 'dashboard.logout', 'uses' => 'DashboardController@getLogout']);

    /* By Samah Kullab */
    Route::resource('courts', 'CourtController');

    /* By Doaa Alastal */
    // Types ROUTE
    Route::resource('types', 'TypeController');
    // Lawsuit ROUTE
    Route::get('lawsuits', ['as' => 'lawsuits.view', 'uses' => 'LawsuitController@getIndex']);
    Route::get('lawsuits/list', ['as' => 'lawsuits.list', 'uses' => 'LawsuitController@getList']);
    Route::get('lawsuits/add', ['as' => 'lawsuits.add',  'uses' => 'LawsuitController@getAdd']); /* kind = pass child (log) if you want to transfer lawsuit to another court ; parent_id = pass parent_id if you want to transfer lawsuit to another court ;  */
    Route::post('lawsuits/add', ['as' => 'lawsuits.add',  'uses' => 'LawsuitController@postAdd']); /* kind = pass child (log) if you want to transfer lawsuit to another court ; id = pass parent_id if you want to transfer lawsuit to another court ;  */
    Route::get('lawsuits/edit/{id}', ['as' => 'lawsuits.edit',  'uses' => 'LawsuitController@getEdit']);
    Route::post('lawsuits/edit/{id}', ['as' => 'lawsuits.edit', 'uses' => 'LawsuitController@postEdit']);
    Route::get('lawsuits/delete/{id}', ['as' => 'lawsuits.delete',  'uses' => 'LawsuitController@getDelete']);
    Route::get('lawsuits/archive/{id}', ['as' => 'lawsuits.archive',  'uses' => 'LawsuitController@getArchive']);
    Route::get('lawsuits/show-{kind}/{id}', ['as' => 'lawsuits.show',  'uses' => 'LawsuitController@getShow']); /* id = Lawsuit id ;  kind = parent or child (log) */

    // Lawsuit Logs ROUTE
    Route::get('lawsuits/logs/{id}', ['as' => 'lawsuits.logs',  'uses' => 'LawsuitController@getLogs']); /* id = Lawsuit id */
    Route::get('lawsuits/logs/list/{id}', ['as' => 'lawsuits.logs.list',  'uses' => 'LawsuitController@getLogsList']); /* id = Lawsuit id */
    Route::get('lawsuits/logs/add/{id}', ['as' => 'logs.add',  'uses' => 'LawsuitController@getAdd']); /* id = parent_id */
    Route::post('lawsuits/logs/add/{id}', ['as' => 'logs.add',  'uses' => 'LawsuitController@postAdd']); /* id = parent_id */

    Route::get('lawsuits/logs/edit/{id}', ['as' => 'logs.edit',  'uses' => 'LawsuitController@getEdit']); /* id = Log id */
    Route::post('lawsuits/logs/edit/{id}', ['as' => 'logs.edit',  'uses' => 'LawsuitController@postEdit']); /* id = Log id */
    Route::get('lawsuits/logs/delete/{id}', ['as' => 'logs.delete',  'uses' => 'LawsuitController@getDelete']); /* id = Log id */

});


//Dictionary Route
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function ()
{
    Route::get('dictionary.js', function () {
        return response()->view('admin.common.general')->header('content-type', 'text/javascript; charset=utf-8');
    })->name('admin.common.general');

});
