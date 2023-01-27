<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
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

Route::controller(EventController::class)->group(function () {
    Route::get('admin/events', 'index')->name('events.index');
    Route::post('admin/events', 'store')->name('events.store');
    Route::get('admin/events/create', 'create')->name('events.create');
    Route::get('admin/events/view/{id}', 'detail')->name('events.view');
    Route::post('admin/events/delete/{id}', 'delete')->name('events.delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
