<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Advance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdvanceController extends Controller
{
    public function index()
    {
        $advances = $this->ownAdvances()->with('agent')->latest('issued_on')->paginate(20);

        return view('agency.advances.index', compact('advances'));
    }

    public function create()
    {
        $agents = User::where('agency_id', auth()->user()->agency_id)->where('role', 'agent')->active()->orderBy('name')->get();

        return view('agency.advances.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => ['required', Rule::exists('users', 'id')->where('agency_id', auth()->user()->agency_id)->where('role', 'agent')],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'reason' => ['nullable', 'string', 'max:255'],
            'monthly_deduct' => ['required', 'numeric', 'min:0.01'],
            'issued_on' => ['required', 'date'],
        ]);

        $advance = Advance::create([
            ...$validated,
            'agency_id' => auth()->user()->agency_id,
            'balance' => $validated['amount'],
            'status' => 'active',
        ]);

        ActivityLog::record('advance_issued', 'Advance of PKR '.number_format($advance->amount, 0)." issued to '{$advance->agent->name}'", $advance->agency_id, 'Advance', $advance->id);

        return redirect()->route('agency.advances.index')->with('success', 'Advance recorded.');
    }

    /**
     * Written off, not deleted — the debt stops being deducted from future
     * payroll but the record stays visible as an accepted loss, same as a
     * cancelled invoice or a reversed commission.
     */
    public function writeOff(Advance $advance)
    {
        abort_unless($advance->agency_id === auth()->user()->agency_id, 404);
        abort_unless($advance->status === 'active', 409);

        $advance->update(['status' => 'written_off']);

        ActivityLog::record('advance_written_off', "Advance #{$advance->id} for '{$advance->agent->name}' written off (PKR ".number_format($advance->balance, 0).' unrecovered)', $advance->agency_id, 'Advance', $advance->id);

        return back()->with('success', 'Advance written off.');
    }

    private function ownAdvances()
    {
        return Advance::where('agency_id', auth()->user()->agency_id);
    }
}
