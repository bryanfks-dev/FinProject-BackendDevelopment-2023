<?php

use Illuminate\Support\Facades\Artisan;

/* Controllers path */
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingInvoiceController;
use App\Http\Controllers\InvoiceController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Link storage
Artisan::call('storage:link');

/* User pages router */
Route::group(['middleware' => 'guest'], function() {
    // Register page
    Route::group(['prefix' => 'register'], function() {
        Route::get('/', [RegisterController::class, 'view']);

        Route::post('/', [RegisterController::class, 'create_user']);
    });

    // Login page
    Route::group(['prefix' => 'login'], function() {
        Route::get('/', [LoginController::class, 'view'])->name('login');

        Route::post('/', [LoginController::class, 'auth'])->middleware('throttle:login');
    });
});

// Market page
Route::group(['prefix' => '/'], function() {
    Route::get('/', [MarketController::class, 'view'])->name('market');

    Route::get('/add/{id}', [MarketController::class, 'add_to_cart'])->middleware(['auth', 'user']);
});

Route::group(['middleware' => ['auth', 'user']], function() {
    // Shopping cart page
    Route::group(['prefix' => 'cart'], function() {
        Route::get('/', [ShoppingCartController::class, 'view']);

        Route::get('/min/{id}', [ShoppingCartController::class, 'decrease_quantity']);

        Route::get('/plus/{id}', [ShoppingCartController::class, 'increase_quantity']);

        Route::get('/drop/{id}', [ShoppingCartController::class, 'delete_order']);

        Route::get('/proceed_order', [ShoppingCartController::class, 'proceed_order']);
    });

    // Invoice page
    Route::group(['prefix' => 'invoice'], function() {
        Route::get('/', [InvoiceController::class, 'view']);

        Route::get('/cancel/{id}', [InvoiceController::class, 'cancel_invoice']);

        Route::get('/submit/{id}', [InvoiceController::class, 'submit_invoice']);
    });
});

/* Admin pages router */
Route::group(['middleware' => 'admin'], function() {
    // Dashboard page
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/', [DashboardController::class, 'view'])->name('dashboard');

        Route::post('/add_item', [DashboardController::class, 'create_item']);

        Route::get('/sort_item/{by}', [DashboardController::class, 'sort_item']);

        Route::get('/search', [DashboardController::class, 'search_item']);

        Route::post('/update_item/{id}', [DashboardController::class, 'update_item']);

        Route::get('/delete_item/{id}', [DashboardController::class, 'delete_item']);
    });

    // Incoming invoice page
    Route::group(['prefix' => 'incoming_invoice'], function() {
        Route::get('/', [IncomingInvoiceController::class, 'view']);

        Route::get('/sort/{by}', [IncomingInvoiceController::class, 'sort_invoice']);

        Route::get('/search', [IncomingInvoiceController::class, 'search_invoice']);

        Route::get('/view/{id}', [IncomingInvoiceController::class, 'view_invoice']);
    });
});

/* All user page(s) */
// Logout
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
