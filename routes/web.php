<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LegoSetController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LegoSetUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
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

Route::get('/', function () {
    return view('main');
});

// Регистрация и авторизация
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Главная страница
Route::get('/', [LegoSetUserController::class, 'index'])->name('lego_sets.index');

// Подробная страница товара
Route::get('/lego_sets/{id}', [LegoSetUserController::class, 'show'])->name('lego_sets.show');

// Отзыв
Route::post('/review/{legoSet}', [ReviewController::class, 'store'])->name('reviews.store');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{legoSet}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/{item}', [CartController::class, 'updateCartItem'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'deleteCartItem'])->name('cart.destroy');

// Оформление заказа
Route::get('/order', [OrderController::class, 'index']);
Route::post('/order/create', [OrderController::class, 'store'])->name('createOrder');

// Админ-панель
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/lego_sets', [LegoSetController::class, 'index'])->name('admin.lego_sets.index')->middleware('auth')->middleware('admin');
Route::get('/admin/lego_sets/create', [LegoSetController::class, 'show'])->name('admin.lego_sets.create')->middleware('auth')->middleware('admin');
Route::get('/admin/lego_sets/edit/{id}', [LegoSetController::class, 'edit'])->name('admin.lego_sets.edit')->middleware('auth')->middleware('admin');

Route::post('/admin/lego_sets/create', [LegoSetController::class, 'store'])->name('admin.lego_sets.store')->middleware('auth')->middleware('admin');
Route::post('/admin/lego_sets/update/{legoSet}', [LegoSetController::class, 'update'])->name('admin.lego_sets.update')->middleware('auth')->middleware('admin');
Route::delete('/admin/lego_sets/destroy/{legoSet}', [LegoSetController::class, 'destroy'])->name('admin.lego_sets.destroy')->middleware('auth')->middleware('admin');

Route::get('/admin/lego_series', [AdminController::class, 'indexSeries'])->name('admin.lego_series.index')->middleware('auth')->middleware('admin');;
Route::post('/admin/lego_series/create', [AdminController::class, 'storeSeries'])->name('admin.lego_series.store')->middleware('auth')->middleware('admin');;

Route::get('/admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index')->middleware('auth')->middleware('admin');
Route::put('/admin/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.updateStatus')->middleware('auth')->middleware('admin');
