<?php

use App\Http\Controllers\Admin\ContactClickController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageDetailController;
use Illuminate\Support\Facades\Route;

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

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
        Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('contact-clicks', [ContactClickController::class, 'index'])->name('contact-clicks.index');
        Route::delete('contact-clicks/{contactClick}', [ContactClickController::class, 'destroy'])->name('contact-clicks.destroy');
    });
});
