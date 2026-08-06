<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\AgencyInvoice;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgencyBillingController extends Controller
{
    public function updatePlan(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'plan_id' => ['nullable', Rule::exists('plans', 'id')],
        ]);

        $oldPlan = $agency->plan?->name ?? 'No plan';
        $agency->update($validated);
        $newPlan = $agency->fresh()->plan?->name ?? 'No plan';

        ActivityLog::record('agency_plan_changed', "Agency '{$agency->name}' plan changed from '{$oldPlan}' to '{$newPlan}'", $agency->id, 'Agency', $agency->id);

        return back()->with('success', 'Plan updated.');
    }

    public function storeInvoice(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'plan_id' => ['nullable', Rule::exists('plans', 'id')],
            'amount' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $plan = $validated['plan_id'] ? Plan::find($validated['plan_id']) : $agency->plan;

        $invoice = AgencyInvoice::create([
            ...$validated,
            'agency_id' => $agency->id,
            'plan_id' => $plan?->id,
            'plan_name_snapshot' => $plan?->name ?? 'Custom',
            'status' => 'pending',
        ]);

        ActivityLog::record('invoice_created', "Invoice #{$invoice->id} ({$invoice->plan_name_snapshot}, PKR {$invoice->amount}) created for '{$agency->name}'", $agency->id, 'AgencyInvoice', $invoice->id);

        return back()->with('success', 'Invoice recorded.');
    }

    public function markInvoicePaid(Request $request, AgencyInvoice $invoice)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:255'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $invoice->update([
            ...$validated,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        ActivityLog::record('invoice_paid', "Invoice #{$invoice->id} for '{$invoice->agency->name}' marked paid via {$invoice->payment_method}", $invoice->agency_id, 'AgencyInvoice', $invoice->id);

        return back()->with('success', 'Invoice marked as paid.');
    }

    /**
     * Voided, not deleted — it's a financial record; the row (and whatever
     * led to it being wrong) needs to stay visible in the history.
     */
    public function cancelInvoice(AgencyInvoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);

        ActivityLog::record('invoice_cancelled', "Invoice #{$invoice->id} for '{$invoice->agency->name}' cancelled", $invoice->agency_id, 'AgencyInvoice', $invoice->id);

        return back()->with('success', 'Invoice cancelled.');
    }
}
