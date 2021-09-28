<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DispositionController;
use App\Http\Controllers\Web\InboxController;
use App\Http\Controllers\Web\OutboxController;
use App\Http\Controllers\Web\TypeController;

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



Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/item', [DashboardController::class, 'index'])->name('dashboarddot');
    Route::resource('inbox', InboxController::class);
    Route::resource('outbox', OutboxController::class);
    Route::resource('type', TypeController::class);
    Route::resource('disposition', DispositionController::class);
});


