<?php

/* Controllers path */
use App\Http\Controllers\HomePathController;
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

/* User pages router */
// Default path page
Route::get('/', [HomePathController::class, 'view']);

// Register page
Route::group(['prefix' => '/register',
            'middleware' => 'guest'], function() {
    Route::get('/register', [RegisterController::class, 'view']);

    Route::post('/register', [RegisterController::class, 'create_user']);
});

// Login page
Route::get('/login', [LoginController::class, 'view'])->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'auth'])->middleware('guest');

// Market page
Route::get('/market', [MarketController::class, 'view'])->name('market');

Route::get('/market/add/{id}', [MarketController::class, 'add_to_cart'])->middleware('user');

// Shopping cart page
Route::get('/cart', [ShoppingCartController::class, 'view'])->middleware(['auth', 'user']);

Route::get('/cart/drop/{id}', [ShoppingCartController::class, 'delete_order'])->middleware(['auth', 'user']);

Route::get('/cart/{action}/{id}', [ShoppingCartController::class, 'update_quantity'])->middleware(['auth', 'user']);

Route::get('/cart/proceed_order', [ShoppingCartController::class, 'proceed_order'])->middleware(['auth', 'user']);

// Invoice page
Route::get('/invoice', [InvoiceController::class, 'view'])->middleware(['auth', 'user']);

Route::get('/invoice/{action}/{id}', [InvoiceController::class, 'proceed_invoice'])->middleware(['auth', 'user']);

/* Admin pages router */
Route::group(['middleware' => 'admin'], function() {
    // Dashboard page
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/', [DashboardController::class, 'view']);

        Route::post('/add_item', [DashboardController::class, 'create_item']);

        Route::get('/sort_item/{by}', [DashboardController::class, 'sort_item']);

        Route::get('/search', [DashboardController::class, 'search_item']);

        Route::post('/update_item/{id}', [DashboardController::class, 'update_item']);

        Route::get('/delete_item/{id}', [DashboardController::class, 'delete_item']);
    });

    // Incoming invoice page
    Route::group(['prefix' => 'incoming_invoice'], function() {
        Route::get('/incoming_invoice', [IncomingInvoiceController::class, 'view']);

        Route::get('/incoming_invoice/view/{id}', [IncomingInvoiceController::class, 'view_invoice']);

        Route::get('/incoming_invoice/sort/{by}', [IncomingInvoiceController::class, 'sort_invoice']);

        Route::get('/incoming_invoice/search', [IncomingInvoiceController::class, 'search_invoice']);
    });
});

/* All user page(s) */
// Logout
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
