<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::get('/', 'HomeController@index')->name('home.index');
//    Route::get('/home', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['auth', 'permission']], function() {
        Route::group(['prefix' => 'tasks'], function() {
            Route::get('/', 'TaskController@index')->name('tasks.index');
            Route::post('/', 'TaskController@store')->name('tasks.store');
            Route::patch('/{id}', 'TaskController@update')->name('tasks.update');
            Route::get('/update/{id}', 'TaskController@edit')->name('tasks.edit');
            Route::get('/create', 'TaskController@create')->name('tasks.create');
            Route::get('/show/{id}', 'TaskController@show')->name('tasks.show');
        });

        Route::group(['prefix' => 'attendance'], function() {
            Route::get('/', 'AttendanceController@index')->name('attendance.index');
            Route::post('/checkin', 'AttendanceController@checkIn')->name('attendance.checkin');
            Route::post('/checkout', 'AttendanceController@checkOut')->name('attendance.checkout');
            Route::get('/download', 'AttendanceController@generatePDF')->name('attendance.download.pdf');
        });

        Route::group(['prefix' => 'admin'], function() {
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', 'UsersController@index')->name('users.index');
                Route::get('/create', 'UsersController@create')->name('users.create');
                Route::post('/create', 'UsersController@store')->name('users.store');
                Route::get('/{user}/show', 'UsersController@show')->name('users.show');
                Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
                Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
                Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
            });

            Route::group(['prefix' => 'events'], function() {
                Route::get('/', 'EventController@index')->name('events.index');
                Route::post('/create', 'EventController@store')->name('events.store');
                Route::get('/create', 'EventController@create')->name('events.create');
                Route::get('/{event}/show', 'EventController@show')->name('events.show');
                Route::get('/{event}/edit', 'EventController@edit')->name('events.edit');
                Route::patch('/{event}/update', 'EventController@update')->name('events.update');
                Route::delete('/{event}/delete', 'EventController@destroy')->name('events.destroy');
            });

            Route::group(['prefix' => 'posts'], function() {
                Route::get('/', 'PostController@index')->name('posts.index');
                Route::post('/create', 'PostController@store')->name('posts.store');
                Route::get('/create', 'PostController@create')->name('posts.create');
                Route::get('/{post}/show', 'PostController@show')->name('posts.show');
                Route::get('/{post}/edit', 'PostController@edit')->name('posts.edit');
                Route::patch('/{post}/update', 'PostController@update')->name('posts.update');
                Route::delete('/{post}/delete', 'PostController@destroy')->name('posts.destroy');
            });

            Route::get('/attendance', 'AttendanceController@admin')->name('attendance.admin');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});

Auth::routes();

Route::get('/serve', function () {
    Artisan::call('serve');
});

Route::get('/migrate', function () {
    Artisan::call('migrate:refresh');
});
Route::get('/link', function () {
    Artisan::call('storage:link');
});
Route::get('/permission', function () {
    Artisan::call('permission:create-permission-routes');
});
Route::get('/admin/seed', function () {
    Artisan::call('db:seed --class=CreateAdminUserSeeder');
});
