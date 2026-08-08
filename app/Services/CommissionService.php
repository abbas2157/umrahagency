<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Commission;
use App\Models\CompensationPlan;
use App\Models\Payment;

class CommissionService
{
    /**
     * Commission accrues on money received, not on the booking being made —
     * a payment against a booking earns its slice of commission the moment
     * it's recorded, in proportion to how much of the total price it covers.
     */
    public function accrueForPayment(Payment $payment): ?Commission
    {
        $booking = $payment->booking;

        if (! $booking->agent_id || (float) $payment->amount <= 0) {
            return null;
        }

        $compensation = $booking->agent->currentCompensation();

        if (! $compensation || ! in_array($compensation->plan->type, ['commission', 'salary_commission'], true)) {
            return null;
        }

        $amount = $this->calculateAmount($compensation->plan, $booking, (float) $payment->amount);

        if ($amount <= 0) {
            return null;
        }

        return Commission::create([
            'agency_id' => $booking->agency_id,
            'agent_id' => $booking->agent_id,
            'booking_id' => $booking->id,
            'payment_id' => $payment->id,
            'amount' => $amount,
            'status' => 'accrued',
        ]);
    }

    /**
     * A refund never edits or deletes the original accrual — this ledger is
     * append-only — so it books an equal-and-opposite negative row instead.
     * If the original was already paid out, the negative row simply nets
     * against the agent's next payroll.
     */
    public function reverseForPayment(Payment $payment): ?Commission
    {
        $original = Commission::where('payment_id', $payment->id)
            ->where('amount', '>', 0)
            ->first();

        if (! $original) {
            return null;
        }

        return Commission::create([
            'agency_id' => $original->agency_id,
            'agent_id' => $original->agent_id,
            'booking_id' => $original->booking_id,
            'payment_id' => $original->payment_id,
            'amount' => -abs($original->amount),
            'status' => 'reversed',
            'note' => 'Reversal of payment #'.$payment->id.' being refunded',
        ]);
    }

    private function calculateAmount(CompensationPlan $plan, Booking $booking, float $paymentAmount): float
    {
        return match ($plan->commission_type) {
            'percent_margin' => $this->percentMargin($plan, $booking, $paymentAmount),
            'fixed_per_tier' => $this->fixedPerTier($plan, $booking, $paymentAmount),
            default => round($paymentAmount * ((float) $plan->commission_rate / 100), 2),
        };
    }

    /**
     * Margin is unknown until an agency fills in cost_price on the booking —
     * until then this correctly pays 0 rather than guessing.
     */
    private function percentMargin(CompensationPlan $plan, Booking $booking, float $paymentAmount): float
    {
        $totalPrice = (float) $booking->total_price;

        if ($totalPrice <= 0 || $booking->cost_price === null) {
            return 0.0;
        }

        $marginRatio = ($totalPrice - (float) $booking->cost_price) / $totalPrice;

        return round($paymentAmount * $marginRatio * ((float) $plan->commission_rate / 100), 2);
    }

    /**
     * A flat amount per package tier, accrued in the same proportion as the
     * booking has been paid off — so a booking paid in two halves earns half
     * the tier commission per payment, not the full amount twice.
     */
    private function fixedPerTier(CompensationPlan $plan, Booking $booking, float $paymentAmount): float
    {
        $totalPrice = (float) $booking->total_price;
        $tierAmount = (float) ($plan->tier_rates[$booking->package_tier] ?? 0);

        if ($totalPrice <= 0 || $tierAmount <= 0) {
            return 0.0;
        }

        return round($tierAmount * ($paymentAmount / $totalPrice), 2);
    }
}
