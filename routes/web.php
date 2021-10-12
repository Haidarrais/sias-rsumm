<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DispositionController;
use App\Http\Controllers\Web\DivisionController;
use App\Http\Controllers\Web\InboxController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\OutboxController;
use App\Http\Controllers\Web\ReportController;
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
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::resource('inbox', InboxController::class);
    Route::resource('outbox', OutboxController::class);
    Route::resource('type', TypeController::class);
    Route::resource('disposition', DispositionController::class);
    Route::resource('division', DivisionController::class);
    Route::get('/notifMemo/{id?}', [NotificationController::class, 'memo'])->name('notif.memo');
    Route::get('/notifInbox/{id}', [NotificationController::class, 'inbox'])->name('notif.inbox');
    Route::get('/notifOutbox/{id}', [NotificationController::class, 'outbox'])->name('notif.outbox');
});


