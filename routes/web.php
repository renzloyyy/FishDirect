<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FishermanController;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\Request;
// Main Page Route
Route::middleware(['auth', 'consumer'])->get('/consumer/dashboard', [Analytics::class, 'consumer'])->name('consumer-dashboard');
Route::middleware(['auth','fisher'])->get('/fisherman/dashboard', [Analytics::class, 'fisherman'])->name('fisherman-dashboard');

// Pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');

// Authentication
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/login', [LoginBasic::class, 'login'])->name('login.perform');

Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth.register-basic');
Route::post('/auth/register-basic', [RegisterBasic::class, 'register'])->name('auth.register.perform');

Route::get('/auth/fisher-basic', [RegisterBasic::class, 'fisher'])->name('auth.register-fisher');
Route::post('/auth/fisher-basic', [RegisterBasic::class, 'registerFisher'])->name('auth.register-fisher.perform');

Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [ConsumerController::class, 'index'])->name('complete-profile');
    Route::post('/complete-profile', [ConsumerController::class, 'updateProfile'])->name('complete-profile.update');
    Route::get('/consumer/profile', [ConsumerController::class, 'showProfile'])->name('consumer.profile');
    Route::get('/cart', [CartController::class, 'viewCartPage'])->name('cart');
    Route::get('/delivery-faq', [ConsumerController::class, 'deliveryFaq'])->name('delivery.faq');
    Route::get('/about', [ConsumerController::class, 'aboutUs'])->name('about-us');
    Route::post('/cart/add', [ProductController::class, 'add'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/orders/active', [ConsumerController::class, 'MyOrder'])->name('Orders');
    Route::post('/apply-promo', [CartController::class, 'apply'])->name('promo.apply');

   Route::post('/remove-promo', function () {
    session()->forget(['promo_code', 'promo_type', 'promo_value']);
    return back()->with('success', 'Promo code removed.');
})->name('promo.remove');





});


Route::middleware(['auth'])->group(function () {
    Route::get('/fisher/complete-profile', [FishermanController::class, 'index'])->name('fisher.complete-profile');
    Route::post('/fisher/complete-profile', [FishermanController::class, 'updateProfile'])->name('fisher.complete-profile.update');
    Route::get('/fisherman/support/faq', [FishermanController::class, 'fisherFaq'])->name('fisher.faq');
    Route::post('/catches/store', [FishermanController::class, 'storeCatch'])->name('catches.store');
    Route::get('/mycatch', [FishermanController::class, 'myCatch'])->name('mycatch');
    Route::post('/catches/{id}', [FishermanController::class, 'updateCatch'])->name('catches.update');
    Route::put('/catches/{id}', [FishermanController::class, 'updateCatch'])->name('catches.update');
    Route::get('/order', [FishermanController::class, 'viewOrder'])->name('catches.order');
    Route::post('/orders/{order}/confirm', [FishermanController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/status', [FishermanController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/export-pdf', [FishermanController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/fisher/orders/filter', [FishermanController::class, 'filterOrders'])->name('fisher.orders.filter');
    Route::get('/fisher/my-catch/filter', [FishermanController::class, 'filterMyCatch'])->name('fisherman.my-catch.filter');
    Route::get('/fisher/export-pdf', [FishermanController::class, 'exportcatchpdf'])->name('fisherman.my-catch.export');


});

Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
