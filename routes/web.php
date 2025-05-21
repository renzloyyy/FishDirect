<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FishermanController;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\Request;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\FisherEarningsController;
    // Main Page Route
   Route::middleware(['auth', 'role:Consumer'])->get('/consumer/dashboard', [Analytics::class, 'consumer'])->name('consumer-dashboard');
   Route::middleware(['auth', 'role:Fisher'])->get('/fisherman/dashboard', [Analytics::class, 'fisherman'])->name('fisherman-dashboard');


// Pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');

// Authentication
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/login', [LoginBasic::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.perform');

Route::get('login/{provider}', [SSOController::class, 'redirectToProvider'])->name('login.sso');
Route::get('login/{provider}/callback', [SSOController::class, 'callback'])->name('login.sso.callback');


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
    Route::get('/fresh-catches', [ConsumerController::class, 'freshCatches'])->name('fresh-catches');
    Route::get('/delivery-faq', [ConsumerController::class, 'deliveryFaq'])->name('delivery.faq');
    Route::get('/about', [ConsumerController::class, 'aboutUs'])->name('about-us');
    Route::post('/cart/add', [ProductController::class, 'add'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/consumer/orders', [ConsumerController::class, 'MyOrder'])->name('consumer.orders');
    Route::get('/profile', [Analytics::class, 'profile'])->name('profile');
    Route::post('/apply-promo', [CartController::class, 'apply'])->name('promo.apply');
    Route::get('/profile/edit', [App\Http\Controllers\dashboard\Analytics::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\dashboard\Analytics::class, 'updateProfile'])->name('profile.update');


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
    Route::get('/fisher/orders', [FishermanController::class, 'viewOrder'])->name('catches.order');
    Route::post('/orders/{order}/confirm', [FishermanController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/status', [FishermanController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/export-pdf', [FishermanController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/fisher/orders/filter', [FishermanController::class, 'filterOrders'])->name('fisher.orders.filter');
    Route::get('/fisher/my-catch/filter', [FishermanController::class, 'filterMyCatch'])->name('fisherman.my-catch.filter');
    Route::get('/fisher/export-pdf', [FishermanController::class, 'exportcatchpdf'])->name('fisherman.my-catch.export');
    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings.index');
    Route::get('/earnings/export', [EarningsController::class, 'exportPdf'])->name('earnings.export');
    Route::post('/earnings/{earning}/update-status', [EarningsController::class, 'updatePayoutStatus'])->name('earnings.update-status');
    Route::get('/earnings/analytics', [EarningsController::class, 'getEarningsAnalytics'])->name('earnings.analytics');
    Route::post('/orders/{order}/delivery', [EarningsController::class, 'processDelivery'])->name('orders.process-delivery');
    Route::put('/fisher/update-payout-info', [EarningsController::class, 'updatePayoutInfo'])->name('fisher.update-payout-info');
    Route::put('fisherman/my-catch/{id}', [FishermanController::class, 'updateMyCatch'])->name('my-catch.update');
    Route::delete('/my-catch/{id}', [FishermanController::class, 'destroyCatch'])->name('my-catch.destroy');

});

Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
