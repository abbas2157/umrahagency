<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class BillingController extends Controller
{
    /**
     * Read-only for the Agency Admin — payment confirmation and plan
     * changes are Super Admin actions (see Admin\AgencyBillingController),
     * so there's nothing to mutate here, only to see: current plan, what
     * else is available, and invoice history.
     */
    public function index()
    {
        $agency = auth()->user()->agency;

        $invoices = $agency->invoices()->with('plan')->get();
        $plans = Plan::active()->orderBy('price')->get();

        return view('agency.billing.index', compact('agency', 'invoices', 'plans'));
    }
}
