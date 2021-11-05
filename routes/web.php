<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\User\HomeController as UserDashboardController;
use App\Http\Controllers\User\PortfolioController;
use App\Http\Controllers\User\SettingController;
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
        Route::get('home', [UserDashboardController::class, 'index'])->name('home.index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::resource('portfolios', PortfolioController::class)->only('index','show');
        Route::get('portfolios/trades/{trade}', [PortfolioController::class, 'showTrade'])->name('trades.show');
        Route::get('export/portfolio/{portfolio}', [PortfolioController::class, 'export'])->name('portfolio.export');
    });
});



require_once __DIR__ . '/jetstream.php';
