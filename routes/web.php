<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
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
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' => 'auth', 'verified'], function () {
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('users', UserController::class)->name('*', 'user')->only('index', 'create', 'edit');
        Route::resource('transactions', TransactionController::class)->name('*', 'transaction')->only('index', 'edit');
        Route::resource('packages', PackageController::class)->name('*', 'package')->only('index', 'edit', 'create');
        Route::resource('subscriptions', SubscriptionController::class)->name('*', 'subscription')->only('index','edit','create');
    });

    Route::group(['middleware' => 'role:user', 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
    });
});

require_once __DIR__ . '/jetstream.php';
