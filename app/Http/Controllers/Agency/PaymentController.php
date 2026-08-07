<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\CommissionService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private CommissionService $commissions) {}

    public function store(Request $request, Booking $booking)
    {
        $this->authorizeOwnBooking($booking);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'received_at' => ['required', 'date'],
            'method' => ['nullable', 'string', 'max:100'],
            'reference' => ['nullable', 'string', 'max:100'],
        ]);

        $payment = $booking->payments()->create([
            ...$validated,
            'status' => 'received',
            'recorded_by' => auth()->id(),
        ]);

        $this->commissions->accrueForPayment($payment);

        ActivityLog::record('payment_recorded', "Payment of PKR ".number_format($payment->amount, 0)." recorded against booking #{$booking->id}", $booking->agency_id, 'Payment', $payment->id);

        return back()->with('success', 'Payment recorded.');
    }

    /**
     * A refund never deletes the payment — it flips status so the booking's
     * total-received figure and the commission ledger both stay honest.
     */
    public function refund(Booking $booking, Payment $payment)
    {
        $this->authorizeOwnBooking($booking);

        abort_unless($payment->booking_id === $booking->id, 404);
        abort_if($payment->status === 'refunded', 409);

        $payment->update(['status' => 'refunded']);

        $this->commissions->reverseForPayment($payment);

        ActivityLog::record('payment_refunded', "Payment of PKR ".number_format($payment->amount, 0)." refunded on booking #{$booking->id}", $booking->agency_id, 'Payment', $payment->id);

        return back()->with('success', 'Payment marked as refunded.');
    }

    private function authorizeOwnBooking(Booking $booking): void
    {
        abort_unless($booking->agency_id === auth()->user()->agency_id, 404);

        if (auth()->user()->isAgent()) {
            abort_unless($booking->agent_id === auth()->id(), 404);
        }
    }
}
