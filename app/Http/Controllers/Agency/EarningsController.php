<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\PayrollItem;

class EarningsController extends Controller
{
    /**
     * Read-only for the agent — a mirror of what the Agency Admin sees on
     * Commissions/Payroll, scoped to just this agent's own money.
     */
    public function index()
    {
        $agent = auth()->user();

        $currentCompensation = $agent->currentCompensation()?->load('plan');

        $commissions = $agent->commissions()->with('booking')->latest()->paginate(15);

        $payrollItems = PayrollItem::where('agent_id', $agent->id)->with('payroll')->latest()->get();

        $advances = $agent->advances()->orderByDesc('issued_on')->get();

        return view('agency.earnings.index', compact('currentCompensation', 'commissions', 'payrollItems', 'advances'));
    }
}
