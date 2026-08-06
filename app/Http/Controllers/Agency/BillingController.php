<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    /**
     * Read-only for the Agency Admin — payment confirmation is a Super
     * Admin action (see Admin\AgencyBillingController), so there's nothing
     * to mutate here, only to see: current plan and invoice history.
     */
    public function index()
    {
        $agency = auth()->user()->agency;

        $invoices = $agency->invoices()->with('plan')->get();

        return view('agency.billing.index', compact('agency', 'invoices'));
    }
}
