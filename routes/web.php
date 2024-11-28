<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\LegoSetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LegoSetUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SalesController;
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

Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', [LegoSetUserController::class, 'index'])->name('lego_sets.index');
Route::get('/lego_sets/{id}', [LegoSetUserController::class, 'show'])->name('lego_sets.show');
Route::post('/review/{legoSet}', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{legoSet}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/{item}', [CartController::class, 'updateCartItem'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'deleteCartItem'])->name('cart.destroy');

Route::get('/order', [OrderController::class, 'index']);
Route::post('/order/create', [OrderController::class, 'store'])->name('createOrder');

Route::get('/admin/lego_sets', [LegoSetController::class, 'index'])->name('admin.lego_sets.index')->middleware('auth')->middleware('admin');
Route::get('/admin/lego_sets/create', [LegoSetController::class, 'show'])->name('admin.lego_sets.create')->middleware('auth')->middleware('admin');
Route::get('/admin/lego_sets/edit/{id}', [LegoSetController::class, 'edit'])->name('admin.lego_sets.edit')->middleware('auth')->middleware('admin');

Route::post('/admin/lego_sets/create', [LegoSetController::class, 'store'])->name('admin.lego_sets.store')->middleware('auth')->middleware('admin');
Route::post('/admin/lego_sets/update/{legoSet}', [LegoSetController::class, 'update'])->name('admin.lego_sets.update')->middleware('auth')->middleware('admin');
Route::delete('/admin/lego_sets/destroy/{legoSet}', [LegoSetController::class, 'destroy'])->name('admin.lego_sets.destroy')->middleware('auth')->middleware('admin');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/sales', [SalesController::class, 'index'])->name('sales');