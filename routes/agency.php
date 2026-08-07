<?php

use App\Http\Controllers\Agency\ActivityLogController;
use App\Http\Controllers\Agency\AgencyProfileController;
use App\Http\Controllers\Agency\AgentController;
use App\Http\Controllers\Agency\BillingController;
use App\Http\Controllers\Agency\BranchController;
use App\Http\Controllers\Agency\DashboardController;
use App\Http\Controllers\Agency\InquiryController;
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
    });
});
