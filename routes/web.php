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

Route::get('/', function () {
//    return view('welcome');
    return redirect('/login');
});

Route::middleware([\App\Http\Middleware\Authenticate::class])->group(function () {
    Route::middleware([\App\Http\Middleware\UserRole::class])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'userIndex'])->name('dashboard');
        Route::post('/create-transaction', [\App\Http\Controllers\TransactionController::class, 'create'])->name('createTransaction');
    });
    Route::middleware([\App\Http\Middleware\AdminRole::class])->group(function () {
        Route::get('/admin-dashboard', [\App\Http\Controllers\UserController::class, 'adminIndex'])->name('admin_dashboard');
    });
});

require __DIR__.'/auth.php';
