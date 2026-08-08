<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\AgencyInvoice;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AgencyBillingController extends Controller
{
    /**
     * Activating a plan is a deliberate event, not a silent field update:
     * it stamps when the subscription started (so the period/renewal date
     * can be derived later) and immediately creates the first invoice for
     * that period. Switching an agency to a different plan goes through
     * the same flow — it's a fresh activation, with its own invoice.
     */
    public function activatePlan(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'plan_id' => ['required', Rule::exists('plans', 'id')],
            'starts_on' => ['required', 'date'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $startsOn = Carbon::parse($validated['starts_on'])->startOfDay();
        $periodEnd = $plan->billing_cycle === 'yearly'
            ? $startsOn->copy()->addYear()->subDay()
            : $startsOn->copy()->addMonth()->subDay();

        $invoice = DB::transaction(function () use ($agency, $plan, $startsOn, $periodEnd) {
            $agency->update([
                'plan_id' => $plan->id,
                'plan_activated_at' => $startsOn,
            ]);

            return AgencyInvoice::create([
                'agency_id' => $agency->id,
                'plan_id' => $plan->id,
                'plan_name_snapshot' => $plan->name,
                'amount' => $plan->price,
                'period_start' => $startsOn,
                'period_end' => $periodEnd,
                'status' => 'pending',
            ]);
        });

        ActivityLog::record(
            'agency_plan_activated',
            "Agency '{$agency->name}' activated on plan '{$plan->name}' starting {$startsOn->toDateString()}",
            $agency->id,
            'Agency',
            $agency->id
        );

        return back()->with('success', "Plan activated. Invoice #{$invoice->id} for PKR ".number_format($plan->price, 0)." ({$startsOn->format('d M')} – {$periodEnd->format('d M Y')}) created.");
    }

    /**
     * Clears the plan without touching invoice history — for correcting a
     * mistaken activation, not a normal part of the billing lifecycle.
     */
    public function removePlan(Agency $agency)
    {
        $oldPlan = $agency->plan?->name ?? 'No plan';

        $agency->update(['plan_id' => null, 'plan_activated_at' => null]);

        ActivityLog::record('agency_plan_removed', "Agency '{$agency->name}' plan removed (was '{$oldPlan}')", $agency->id, 'Agency', $agency->id);

        return back()->with('success', 'Plan removed.');
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
