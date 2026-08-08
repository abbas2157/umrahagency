<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->ownCommissions()->with(['agent', 'booking']);

        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->input('agent_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $commissions = $query->latest()->paginate(25)->withQueryString();

        $agents = User::where('agency_id', auth()->user()->agency_id)->where('role', 'agent')->orderBy('name')->get();

        return view('agency.commissions.index', compact('commissions', 'agents'));
    }

    /**
     * Moves an accrued commission to approved — the checkpoint before it can
     * be pulled into a payroll run. Only accrued rows are eligible; approved,
     * paid, and reversed rows are all end states from here.
     */
    public function approve(Commission $commission)
    {
        abort_unless($commission->agency_id === auth()->user()->agency_id, 404);
        abort_unless($commission->status === 'accrued', 409);

        $commission->update(['status' => 'approved']);

        ActivityLog::record('commission_approved', 'Commission #'.$commission->id.' approved (PKR '.number_format($commission->amount, 0).')', $commission->agency_id, 'Commission', $commission->id);

        return back()->with('success', 'Commission approved.');
    }

    private function ownCommissions()
    {
        return Commission::where('agency_id', auth()->user()->agency_id);
    }
}
