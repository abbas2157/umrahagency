<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Services\PayrollService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PayrollController extends Controller
{
    public function __construct(private PayrollService $payrolls) {}

    public function index()
    {
        $payrolls = $this->ownPayrolls()->withCount('items')->latest('period_month')->paginate(20);

        return view('agency.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        return view('agency.payrolls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period_month' => ['required', 'date'],
        ]);

        $periodMonth = Carbon::parse($validated['period_month'])->startOfMonth();
        $agencyId = auth()->user()->agency_id;

        if ($this->ownPayrolls()->whereDate('period_month', $periodMonth)->exists()) {
            return back()->withErrors(['period_month' => 'A payroll for this period already exists.'])->withInput();
        }

        $payroll = $this->payrolls->generate($agencyId, $periodMonth);

        ActivityLog::record('payroll_generated', 'Payroll for '.$periodMonth->format('F Y').' generated', $agencyId, 'Payroll', $payroll->id);

        return redirect()->route('agency.payrolls.show', $payroll)->with('success', 'Payroll generated as a draft — review before approving.');
    }

    public function show(Payroll $payroll)
    {
        $this->authorizeOwnPayroll($payroll);

        $payroll->load(['items.agent']);

        return view('agency.payrolls.show', compact('payroll'));
    }

    /**
     * Draft-only edits to an item's bonus/other/tax adjustments — once
     * approved, payroll_items are locked and this route refuses further
     * changes so nobody edits a figure after it's been signed off.
     */
    public function updateItem(Request $request, Payroll $payroll, PayrollItem $item)
    {
        $this->authorizeOwnPayroll($payroll);

        abort_unless($item->payroll_id === $payroll->id, 404);
        abort_unless($payroll->status === 'draft', 409);

        $validated = $request->validate([
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'other_deduct' => ['nullable', 'numeric', 'min:0'],
            'tax_deduct' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $bonus = $validated['bonus'] ?? 0;
        $otherDeduct = $validated['other_deduct'] ?? 0;
        $taxDeduct = $validated['tax_deduct'] ?? 0;

        $item->update([
            'bonus' => $bonus,
            'other_deduct' => $otherDeduct,
            'tax_deduct' => $taxDeduct,
            'notes' => $validated['notes'] ?? null,
            'net_payable' => $item->base_salary + $item->commission + $bonus - $item->advance_deduct - $otherDeduct - $taxDeduct,
        ]);

        return back()->with('success', 'Payroll item updated.');
    }

    /**
     * Locks every item's figures — the checkpoint before real money moves.
     */
    public function approve(Payroll $payroll)
    {
        $this->authorizeOwnPayroll($payroll);

        abort_unless($payroll->status === 'draft', 409);

        $this->payrolls->approve($payroll, auth()->id());

        ActivityLog::record('payroll_approved', 'Payroll for '.$payroll->period_month->format('F Y').' approved', $payroll->agency_id, 'Payroll', $payroll->id);

        return back()->with('success', 'Payroll approved.');
    }

    /**
     * Marks the payroll paid, pays out its linked commissions, and draws
     * down every agent's advance balance — the point money actually moves.
     */
    public function pay(Payroll $payroll)
    {
        $this->authorizeOwnPayroll($payroll);

        abort_unless($payroll->status === 'approved', 409);

        $this->payrolls->pay($payroll);

        ActivityLog::record('payroll_paid', 'Payroll for '.$payroll->period_month->format('F Y').' marked paid', $payroll->agency_id, 'Payroll', $payroll->id);

        return back()->with('success', 'Payroll marked as paid.');
    }

    private function ownPayrolls()
    {
        return Payroll::where('agency_id', auth()->user()->agency_id);
    }

    private function authorizeOwnPayroll(Payroll $payroll): void
    {
        abort_unless($payroll->agency_id === auth()->user()->agency_id, 404);
    }
}
