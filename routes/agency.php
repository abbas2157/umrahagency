<?php

use App\Http\Controllers\Agency\ActivityLogController;
use App\Http\Controllers\Agency\AdvanceController;
use App\Http\Controllers\Agency\AgencyProfileController;
use App\Http\Controllers\Agency\AgentController;
use App\Http\Controllers\Agency\BillingController;
use App\Http\Controllers\Agency\BookingController;
use App\Http\Controllers\Agency\BranchController;
use App\Http\Controllers\Agency\CommissionController;
use App\Http\Controllers\Agency\CompensationPlanController;
use App\Http\Controllers\Agency\DashboardController;
use App\Http\Controllers\Agency\EarningsController;
use App\Http\Controllers\Agency\InquiryController;
use App\Http\Controllers\Agency\PayrollController;
use App\Http\Controllers\Agency\PaymentController;
use Illuminate\Support\Facades\Route;

// Agency panel — day-to-day casework for Agency Admin + Agent. Assigning a
// query to an agency in the first place is Super Admin's job, in
// routes/admin.php instead.
Route::prefix('agency')->name('agency.')->middleware(['auth', 'agency.active', 'role:agency_admin,agent', 'locale'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::post('inquiries/{inquiry}/assign-agent', [InquiryController::class, 'assignAgent'])->name('inquiries.assign-agent');
    Route::post('inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::post('inquiries/{inquiry}/notes', [InquiryController::class, 'storeNote'])->name('inquiries.notes');

    Route::middleware('feature:'.\App\Support\Feature::SALARY_COMMISSION)->group(function () {
        Route::resource('bookings', BookingController::class)->except(['destroy']);
        Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('bookings/{booking}/payments', [PaymentController::class, 'store'])->name('bookings.payments.store');
        Route::patch('bookings/{booking}/payments/{payment}/refund', [PaymentController::class, 'refund'])->name('bookings.payments.refund');
    });

    Route::middleware(['role:agent', 'feature:'.\App\Support\Feature::SALARY_COMMISSION])->group(function () {
        Route::get('my-earnings', [EarningsController::class, 'index'])->name('earnings.index');
    });

    Route::middleware('role:agency_admin')->group(function () {
        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

        Route::get('agency-profile', [AgencyProfileController::class, 'edit'])->name('agency-profile.edit');
        Route::put('agency-profile', [AgencyProfileController::class, 'update'])->name('agency-profile.update');

        Route::resource('agents', AgentController::class)->except(['show', 'destroy']);
        Route::get('agents-performance', [AgentController::class, 'performance'])->name('agents.performance');
        Route::patch('agents/{agent}/deactivate', [AgentController::class, 'deactivate'])->name('agents.deactivate');
        Route::patch('agents/{agent}/activate', [AgentController::class, 'activate'])->name('agents.activate');
        Route::get('agents/{agent}/sessions', [AgentController::class, 'sessions'])->name('agents.sessions');
        Route::delete('agents/{agent}/sessions/{sessionId}', [AgentController::class, 'revokeSession'])->name('agents.sessions.revoke');

        Route::resource('branches', BranchController::class)->except(['show', 'destroy']);
        Route::patch('branches/{branch}/deactivate', [BranchController::class, 'deactivate'])->name('branches.deactivate');
        Route::patch('branches/{branch}/activate', [BranchController::class, 'activate'])->name('branches.activate');

        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');

        Route::middleware('feature:'.\App\Support\Feature::SALARY_COMMISSION)->group(function () {
            Route::resource('compensation-plans', CompensationPlanController::class)->except(['show', 'destroy'])->parameters(['compensation-plans' => 'compensationPlan']);
            Route::patch('compensation-plans/{compensationPlan}/deactivate', [CompensationPlanController::class, 'deactivate'])->name('compensation-plans.deactivate');
            Route::patch('compensation-plans/{compensationPlan}/activate', [CompensationPlanController::class, 'activate'])->name('compensation-plans.activate');
            Route::post('agents/{agent}/assign-plan', [CompensationPlanController::class, 'assign'])->name('compensation-plans.assign');

            Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
            Route::patch('commissions/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');

            Route::resource('payrolls', PayrollController::class)->only(['index', 'create', 'store', 'show']);
            Route::patch('payrolls/{payroll}/items/{item}', [PayrollController::class, 'updateItem'])->name('payrolls.items.update');
            Route::patch('payrolls/{payroll}/approve', [PayrollController::class, 'approve'])->name('payrolls.approve');
            Route::patch('payrolls/{payroll}/pay', [PayrollController::class, 'pay'])->name('payrolls.pay');

            Route::resource('advances', AdvanceController::class)->only(['index', 'create', 'store']);
            Route::patch('advances/{advance}/write-off', [AdvanceController::class, 'writeOff'])->name('advances.write-off');
        });
    });
});
