<?php


use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LegoSetController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\LegoSetUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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
// Главная страница
Route::get('/', function () {
    return view('main');
});
Route::get('/', [LegoSetUserController::class, 'index'])->name('lego_sets.index');
Route::get('/load-more-lego', [LegoSetUserController::class, 'loadMore'])->name('lego.loadMore');

// Подробная страница товара
Route::get('/lego_sets/{id}', [LegoSetUserController::class, 'show'])->name('lego_sets.show');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/sales', [SalesController::class, 'index'])->name('sales');
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::middleware('guest')->group(function () {
    // Регистрация и авторизация
    Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Профиль
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{legoSet}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/{item}', [CartController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'deleteCartItem'])->name('cart.destroy');


    // Избранное
    Route::post('/favorites/{legoSet}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{legoSet}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Отзыв
    Route::post('/review/{legoSet}', [ReviewController::class, 'store'])->name('reviews.store');

    // Оформление заказа
    Route::get('/order', [OrderController::class, 'index'])->name('order');
    Route::post('/order/create', [OrderController::class, 'store'])->name('createOrder');
});

Route::middleware('admin')->group(function () {
// Админ-панель
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
    Route::get('/admin/lego_sets', [LegoSetController::class, 'index'])->name('admin.lego_sets.index')->middleware('auth')->middleware('admin');
    Route::get('/admin/lego_sets/create', [LegoSetController::class, 'show'])->name('admin.lego_sets.create')->middleware('auth')->middleware('admin');
    Route::get('/admin/lego_sets/edit/{id}', [LegoSetController::class, 'edit'])->name('admin.lego_sets.edit')->middleware('auth')->middleware('admin');

    Route::post('/admin/lego_sets/create', [LegoSetController::class, 'store'])->name('admin.lego_sets.store')->middleware('auth')->middleware('admin');
    Route::post('/admin/lego_sets/update/{legoSet}', [LegoSetController::class, 'update'])->name('admin.lego_sets.update')->middleware('auth')->middleware('admin');
    Route::delete('/admin/lego_sets/destroy/{legoSet}', [LegoSetController::class, 'destroy'])->name('admin.lego_sets.destroy')->middleware('auth')->middleware('admin');

    Route::get('/admin/lego_series', [AdminController::class, 'indexSeries'])->name('admin.lego_series.index')->middleware('auth')->middleware('admin');;
    Route::post('/admin/lego_series/create', [AdminController::class, 'storeSeries'])->name('admin.lego_series.store')->middleware('auth')->middleware('admin');;

    Route::get('/admin/address', [AdminController::class, 'indexAddress'])->name('admin.address.index')->middleware('auth')->middleware('admin');;
    Route::post('/admin/address/create', [AdminController::class, 'storeAddress'])->name('admin.address.store')->middleware('auth')->middleware('admin');;

    Route::get('/admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index')->middleware('auth')->middleware('admin');
    Route::put('/admin/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.updateStatus')->middleware('auth')->middleware('admin');
});

