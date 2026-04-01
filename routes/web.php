<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

// Thanh toán
Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

// Đơn hàng (bắt buộc đăng nhập)
Route::middleware('auth')->group(function (): void {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/check', [OrderController::class, 'checkForm'])->name('orders.checkForm');
    Route::post('/orders/check', [OrderController::class, 'check'])->name('orders.check');
    Route::get('/orders/{code}', [OrderController::class, 'show'])->name('orders.showByCode');
});

// Dịch vụ & Đặt lịch
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::middleware('auth')->group(function (): void {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

// Đánh giá
Route::middleware('auth')->post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Yêu thích
Route::middleware('auth')->group(function (): void {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{productId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{productId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

// Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Tin tức
Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('posts.show');

// Khu vực Admin
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,staff'])
    ->as('admin.')
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::post('categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');

        Route::resource('products', AdminProductController::class)->except(['show']);

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::match(['post', 'put'], 'orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
        Route::put('users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggleActive');

        Route::resource('services', AdminServiceController::class)->except(['show']);

        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::post('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{review}/status', [AdminReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::post('contacts/{contact}/replied', [AdminContactController::class, 'markReplied'])->name('contacts.markReplied');
    });
