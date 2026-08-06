<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageDetailController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us.html', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/contact-us.html', [HomeController::class, 'contactUs'])->name('contactUs');
Route::get('/reviews.html', [HomeController::class, 'reviews'])->name('reviews');
Route::get('/terms-conditions.html', [HomeController::class, 'termsConditions'])->name('termsConditions');
Route::get('/privacy-policy.html', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/payment-security.html', [HomeController::class, 'paymentSecurity'])->name('paymentSecurity');
Route::get('/cookies-policy.html', [HomeController::class, 'cookiesPolicy'])->name('cookiesPolicy');
Route::get('/hajj-packages.html', [HomeController::class, 'hajj'])->name('hajj');
Route::get('/umrah-visa.html', [HomeController::class, 'umrahVisa'])->name('umrahVisa');
Route::get('/umrah-packages.html', [HomeController::class, 'umrahPackages'])->name('umrahPackages');
Route::get('/umrah-packages-2026.html', [HomeController::class, 'umrahPackages2026'])->name('umrahPackages2026');
Route::get('/december-umrah-packages.html', [HomeController::class, 'decemberUmrahPackages'])->name('decemberUmrahPackages');
Route::get('/umrah-in-ramadan.html', [HomeController::class, 'ramadanUmrah'])->name('ramadanUmrah');
Route::get('/easter-umrah-packages.html', [HomeController::class, 'easterUmrahPackages'])->name('easterUmrahPackages');
Route::get('/lahore-umrah-packages.html', [HomeController::class, 'lahoreUmrah'])->name('lahoreUmrah');

// Package-Detail
Route::get('/umrah/{slug}.html', [PackageDetailController::class, 'show'])->name('umrahDetail');
Route::get('/hajj/{slug}.html', [PackageDetailController::class, 'showHajj'])->name('hajjDetail');

// Inquiry
Route::post('/send-inquiry', [HomeController::class, 'sendInquiry'])->name('sendInquiry');
Route::get('/get-captcha', [HomeController::class, 'getCaptcha'])->name('getCaptcha');
Route::post('/log-contact-click', [HomeController::class, 'logContactClick'])->name('logContactClick');

// Shared auth — one login for every role. Where you land afterward (Super
// Admin → /admin, Agency Admin/Agent → /agency) is decided in
// AdminAuthController, not here.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

        Route::get('forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
        Route::post('forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
        Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    });

    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// Shared self-service account — identical for every role, so it isn't
// nested under /admin or /agency.
Route::middleware(['auth', 'agency.active'])->group(function () {
    Route::get('account', [AccountController::class, 'show'])->name('account.show');
    Route::patch('account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('account/sessions/{sessionId}', [AccountController::class, 'revokeSession'])->name('account.sessions.revoke');
    Route::post('account/sessions/revoke-others', [AccountController::class, 'revokeOtherSessions'])->name('account.sessions.revoke-others');
});
