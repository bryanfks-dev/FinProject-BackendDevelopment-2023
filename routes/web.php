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
Route::get('/register', [RegisterController::class, 'view'])->middleware('guest');

Route::post('/register', [RegisterController::class, 'create_user'])->middleware('guest');

// Login page
Route::get('/login', [LoginController::class, 'view'])->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'auth'])->middleware('guest');

// Market page
Route::get('/market', [MarketController::class, 'view']);

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
// Dashboard page
Route::get('/dashboard', [DashboardController::class, 'view'])->middleware(['auth', 'admin']);

Route::post('/dashboard/add_item', [DashboardController::class, 'create_item'])->middleware(['auth', 'admin']);

Route::get('/dashboard/sort_item/{by}', [DashboardController::class, 'sort_item'])->middleware(['auth', 'admin']);

Route::get('/dashboard/search', [DashboardController::class, 'search_item'])->middleware(['auth', 'admin']);

Route::post('/dashboard/update_item/{id}', [DashboardController::class, 'update_item'])->middleware(['auth', 'admin']);

Route::get('/dashboard/delete_item/{id}', [DashboardController::class, 'delete_item'])->middleware(['auth', 'admin']);

// Incoming invoice page
Route::get('/incoming_invoice', [IncomingInvoiceController::class, 'view'])->middleware(['auth', 'admin']);

Route::get('/incoming_invoice/view/{id}', [IncomingInvoiceController::class, 'view_invoice'])->middleware(['auth', 'admin']);

Route::get('/incoming_invoice/sort/{by}', [IncomingInvoiceController::class, 'sort_invoice'])->middleware(['auth', 'admin']);

Route::get('/incoming_invoice/search', [IncomingInvoiceController::class, 'search_invoice'])->middleware(['auth', 'admin']);

/* All user page(s) */
// Logout
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
