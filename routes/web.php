<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Auth::routes();

Route::controller(EventController::class)->middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/events', 'index')->name('events.index');
    Route::post('admin/events', 'store')->name('events.store');
    Route::get('admin/events/create', 'create')->name('events.create');
    Route::get('admin/events/view/{id}', 'detail')->name('events.view');
    Route::post('admin/events/delete/{id}', 'delete')->name('events.delete');
});

Route::controller(UserController::class)->middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/users', 'index')->name('users.index');
    Route::get('admin/users/{id}/{column_name}/{value}', 'update')
        ->name('users.update');
});

Route::controller(PostController::class)->middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/posts', 'index')->name('posts.index');
    Route::post('admin/posts', 'store')->name('posts.store');
    Route::get('admin/posts/create', 'create')->name('posts.create');
    Route::get('admin/posts/view/{id}', 'detail')->name('posts.view');
    Route::post('admin/posts/delete/{id}', 'delete')->name('posts.delete');
});

Route::controller(TaskController::class)->middleware(['auth'])->group(function () {
    Route::get('tasks', 'index')->name('tasks.index');
    Route::post('tasks', 'store')->name('tasks.store');
    Route::get('tasks/create', 'create')->name('tasks.create');
});

Route::get('/serve', function () {
    Artisan::call('serve');
});
Route::get('/link', function () {
    Artisan::call('storage:link');
});
