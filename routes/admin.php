<?php

use App\Http\Controllers\Admin\AgencyBillingController;
use App\Http\Controllers\Admin\AgencyController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactClickController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Super Admin panel — oversight of the whole platform. Agency Admin/Agent
// casework lives in routes/agency.php instead; see CLAUDE.md §8 for where
// new features belong.
Route::prefix('admin')->name('admin.')->middleware(['auth', 'agency.active', 'role:super_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::post('inquiries/{inquiry}/assign-agency', [InquiryController::class, 'assignAgency'])->name('inquiries.assign-agency');
    Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

    Route::resource('agencies', AgencyController::class)->except(['destroy']);
    Route::post('agencies/{agency}/plan/activate', [AgencyBillingController::class, 'activatePlan'])->name('agencies.plan.activate');
    Route::delete('agencies/{agency}/plan', [AgencyBillingController::class, 'removePlan'])->name('agencies.plan.remove');
    Route::post('agencies/{agency}/invoices', [AgencyBillingController::class, 'storeInvoice'])->name('agencies.invoices.store');

    Route::resource('plans', PlanController::class)->except(['show', 'destroy']);
    Route::patch('plans/{plan}/deactivate', [PlanController::class, 'deactivate'])->name('plans.deactivate');
    Route::patch('plans/{plan}/activate', [PlanController::class, 'activate'])->name('plans.activate');

    Route::patch('invoices/{invoice}/mark-paid', [AgencyBillingController::class, 'markInvoicePaid'])->name('invoices.mark-paid');
    Route::patch('invoices/{invoice}/cancel', [AgencyBillingController::class, 'cancelInvoice'])->name('invoices.cancel');

    Route::resource('users', UserController::class)->except(['show']);

    Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::patch('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::get('users/{user}/sessions', [UserController::class, 'sessions'])->name('users.sessions');
    Route::delete('users/{user}/sessions/{sessionId}', [UserController::class, 'revokeSession'])->name('users.sessions.revoke');

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
