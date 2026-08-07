<?php

namespace App\Services;

use App\Models\Advance;
use App\Models\Commission;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    /**
     * Builds one draft payroll covering every agent who has money owed to
     * them as of the period end: a base salary on their current plan, or an
     * approved commission that hasn't been swept into an earlier payroll
     * yet. Draft items are editable (bonus, other/tax deductions) right up
     * until the payroll is approved.
     */
    public function generate(int $agencyId, Carbon $periodMonth): Payroll
    {
        return DB::transaction(function () use ($agencyId, $periodMonth) {
            $periodEnd = $periodMonth->copy()->endOfMonth();

            $payroll = Payroll::create([
                'agency_id' => $agencyId,
                'period_month' => $periodMonth->copy()->startOfMonth(),
                'status' => 'draft',
            ]);

            $agents = User::where('agency_id', $agencyId)->where('role', 'agent')->get();

            foreach ($agents as $agent) {
                $baseSalary = $this->baseSalaryFor($agent, $periodEnd);
                $commissions = $this->commissionsToSweep($agent, $periodEnd);
                $commissionTotal = $commissions->sum('amount');
                $advanceDeduct = $this->advanceDeductionFor($agent);

                if ($baseSalary <= 0 && $commissionTotal == 0 && $advanceDeduct <= 0) {
                    continue;
                }

                $netPayable = $baseSalary + $commissionTotal - $advanceDeduct;

                PayrollItem::create([
                    'payroll_id' => $payroll->id,
                    'agent_id' => $agent->id,
                    'base_salary' => $baseSalary,
                    'commission' => $commissionTotal,
                    'advance_deduct' => $advanceDeduct,
                    'net_payable' => $netPayable,
                ]);

                if ($commissions->isNotEmpty()) {
                    Commission::whereIn('id', $commissions->pluck('id'))->update(['payroll_id' => $payroll->id]);
                }
            }

            return $payroll;
        });
    }

    /**
     * Locks every item's numbers in place and moves accrued approved
     * commissions no further — pay() is what finally marks them paid and
     * draws down advance balances, so approval is reversible in spirit
     * without touching real money movement yet.
     */
    public function approve(Payroll $payroll, int $approvedBy): void
    {
        $payroll->update(['status' => 'approved', 'approved_by' => $approvedBy]);
    }

    /**
     * The point money actually moves: linked commissions become paid, and
     * each agent's active advances are drawn down by the same amount that
     * was withheld for them at generation time.
     */
    public function pay(Payroll $payroll): void
    {
        DB::transaction(function () use ($payroll) {
            $payroll->update(['status' => 'paid', 'paid_on' => now()]);

            // Reversal rows stay 'reversed' — they were never a payout in
            // their own right, just a clawback of one. Only the positive
            // accruals actually being paid out flip to 'paid'.
            $payroll->commissions()->where('status', 'approved')->update(['status' => 'paid']);

            foreach ($payroll->items as $item) {
                if ($item->advance_deduct > 0) {
                    $this->deductFromAdvances($item->agent_id, (float) $item->advance_deduct);
                }
            }
        });
    }

    private function baseSalaryFor(User $agent, Carbon $asOf): float
    {
        $compensation = $agent->compensationHistory()
            ->whereDate('effective_from', '<=', $asOf)
            ->where(function ($query) use ($asOf) {
                $query->whereNull('effective_to')->orWhereDate('effective_to', '>=', $asOf);
            })
            ->with('plan')
            ->latest('effective_from')
            ->first();

        if (! $compensation || ! in_array($compensation->plan->type, ['salary', 'salary_commission'], true)) {
            return 0.0;
        }

        return (float) $compensation->plan->base_salary;
    }

    /**
     * Approved accruals are always swept in. A reversal (negative row) is
     * only swept alongside them — never left dangling forever — when the
     * accrual it's reversing was itself approved or already paid; if the
     * original was never approved, nothing was ever going to be paid out
     * for it, so the reversal has nothing left to claw back.
     */
    private function commissionsToSweep(User $agent, Carbon $periodEnd)
    {
        $candidates = Commission::where('agent_id', $agent->id)
            ->whereNull('payroll_id')
            ->where('created_at', '<=', $periodEnd)
            ->whereIn('status', ['approved', 'reversed'])
            ->get();

        return $candidates->filter(function (Commission $commission) {
            if ($commission->amount >= 0) {
                return true;
            }

            $original = Commission::where('payment_id', $commission->payment_id)
                ->where('amount', '>', 0)
                ->first();

            return $original && $original->status !== 'accrued';
        });
    }

    private function advanceDeductionFor(User $agent): float
    {
        return $agent->advances()->active()->orderBy('issued_on')->get()
            ->sum(fn (Advance $advance) => min((float) $advance->monthly_deduct, (float) $advance->balance));
    }

    private function deductFromAdvances(int $agentId, float $amount): void
    {
        $advances = Advance::where('agent_id', $agentId)->active()->orderBy('issued_on')->get();

        foreach ($advances as $advance) {
            if ($amount <= 0) {
                break;
            }

            $deduction = min((float) $advance->monthly_deduct, (float) $advance->balance, $amount);
            $newBalance = (float) $advance->balance - $deduction;

            $advance->update([
                'balance' => $newBalance,
                'status' => $newBalance <= 0 ? 'cleared' : 'active',
            ]);

            $amount -= $deduction;
        }
    }
}
