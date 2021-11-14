<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PortfolioController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\TradeController;
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

Route::group(['as' => 'user.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});


Route::group(['middleware' => 'auth:sanctum', 'verified'], function () {
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('users', UserController::class)->only('index', 'create', 'edit', 'show');
        Route::resource('transactions', TransactionController::class)->only('index', 'show');
        Route::resource('packages', PackageController::class)->only('index', 'edit', 'create');
        Route::resource('promocodes', PromocodeController::class)->only('index', 'edit', 'create');
        // Route::resource('subscriptions', SubscriptionController::class)->name('*', 'subscription')->only('show','index');
    });

    Route::group(['middleware' => 'role:user', 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::resource('portfolios', PortfolioController::class)->only('index', 'show');
        Route::resource('trades', TradeController::class)->only('show');
        Route::get('export/portfolio/{portfolio}', [PortfolioController::class, 'export'])->name('portfolio.export');
        Route::resource('transactions', UserTransactionController::class)->only('index', 'show');
    });
});



require_once __DIR__ . '/jetstream.php';
