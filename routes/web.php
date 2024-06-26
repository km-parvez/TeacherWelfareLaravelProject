<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // In routes/web.php
    Route::get('/get-subdistricts/{district}', [ReportController::class, 'getSubdistricts']);
    Route::post('/get-report', [ReportController::class, 'getReport'])->name('report');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/makePayment',[ClientController::class,'makePayment'])->name('makePayment');
    Route::post('/makeWithdraw',[ClientController::class, 'makeWithdraw'])->name('makeWithdraw');
    Route::get('/getLists',[ClientController::class,'getLists'])->name('getLists');
});
