<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AgencyController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactClickController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\UserController;
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

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

        Route::get('forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
        Route::post('forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
        Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    });

    Route::middleware(['auth', 'agency.active'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
        Route::post('inquiries/{inquiry}/assign-agency', [InquiryController::class, 'assignAgency'])->name('inquiries.assign-agency');
        Route::post('inquiries/{inquiry}/assign-agent', [InquiryController::class, 'assignAgent'])->name('inquiries.assign-agent');
        Route::post('inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
        Route::post('inquiries/{inquiry}/notes', [InquiryController::class, 'storeNote'])->name('inquiries.notes');

        Route::get('account', [AccountController::class, 'show'])->name('account.show');
        Route::patch('account', [AccountController::class, 'update'])->name('account.update');
        Route::delete('account/sessions/{sessionId}', [AccountController::class, 'revokeSession'])->name('account.sessions.revoke');
        Route::post('account/sessions/revoke-others', [AccountController::class, 'revokeOtherSessions'])->name('account.sessions.revoke-others');

        Route::middleware('role:super_admin,agency_admin')->group(function () {
            Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
        });

        Route::middleware('role:super_admin')->group(function () {
            Route::resource('agencies', AgencyController::class)->except(['show', 'destroy']);
            Route::resource('users', UserController::class)->except(['show']);

            Route::get('users/{user}/sessions', [UserController::class, 'sessions'])->name('users.sessions');
            Route::delete('users/{user}/sessions/{sessionId}', [UserController::class, 'revokeSession'])->name('users.sessions.revoke');

            Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

            Route::get('contact-clicks', [ContactClickController::class, 'index'])->name('contact-clicks.index');
            Route::delete('contact-clicks/{contactClick}', [ContactClickController::class, 'destroy'])->name('contact-clicks.destroy');

            Route::get('locations', [LocationController::class, 'index'])->name('locations.index');

            Route::get('locations/countries/create', [CountryController::class, 'create'])->name('locations.countries.create');
            Route::post('locations/countries', [CountryController::class, 'store'])->name('locations.countries.store');
            Route::get('locations/countries/{country}/edit', [CountryController::class, 'edit'])->name('locations.countries.edit');
            Route::put('locations/countries/{country}', [CountryController::class, 'update'])->name('locations.countries.update');

            Route::get('locations/provinces/create', [ProvinceController::class, 'create'])->name('locations.provinces.create');
            Route::post('locations/provinces', [ProvinceController::class, 'store'])->name('locations.provinces.store');
            Route::get('locations/provinces/{province}/edit', [ProvinceController::class, 'edit'])->name('locations.provinces.edit');
            Route::put('locations/provinces/{province}', [ProvinceController::class, 'update'])->name('locations.provinces.update');

            Route::get('locations/cities/create', [CityController::class, 'create'])->name('locations.cities.create');
            Route::post('locations/cities', [CityController::class, 'store'])->name('locations.cities.store');
            Route::get('locations/cities/{city}/edit', [CityController::class, 'edit'])->name('locations.cities.edit');
            Route::put('locations/cities/{city}', [CityController::class, 'update'])->name('locations.cities.update');

            Route::get('locations/areas/create', [AreaController::class, 'create'])->name('locations.areas.create');
            Route::post('locations/areas', [AreaController::class, 'store'])->name('locations.areas.store');
            Route::get('locations/areas/{area}/edit', [AreaController::class, 'edit'])->name('locations.areas.edit');
            Route::put('locations/areas/{area}', [AreaController::class, 'update'])->name('locations.areas.update');
        });
    });
});
