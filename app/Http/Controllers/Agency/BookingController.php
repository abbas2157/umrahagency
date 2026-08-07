<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    const TIERS = ['3star', '4star', '5star', 'visa_only'];

    public function index(Request $request)
    {
        $query = $this->ownBookings()->with(['agent', 'inquiry'])->latest('booked_at');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $bookings = $query->paginate(20)->withQueryString();

        return view('agency.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $agents = $this->assignableAgents();
        $inquiries = $this->assignableInquiries();
        $selectedInquiry = $request->filled('inquiry_id')
            ? Inquiry::find($request->input('inquiry_id'))
            : null;

        return view('agency.bookings.create', compact('agents', 'inquiries', 'selectedInquiry'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBooking($request);
        $validated['agency_id'] = auth()->user()->agency_id;

        if (auth()->user()->isAgent()) {
            $validated['agent_id'] = auth()->id();
        }

        $booking = Booking::create($validated);

        ActivityLog::record('booking_created', "Booking #{$booking->id} created (PKR ".number_format($booking->total_price, 0).')', $booking->agency_id, 'Booking', $booking->id);

        return redirect()->route('agency.bookings.show', $booking)->with('success', 'Booking created.');
    }

    public function show(Booking $booking)
    {
        $this->authorizeOwnBooking($booking);

        $booking->load(['agent', 'inquiry', 'payments' => fn ($q) => $q->latest('received_at'), 'commissions']);

        return view('agency.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorizeOwnBooking($booking);

        $agents = $this->assignableAgents();

        return view('agency.bookings.edit', compact('booking', 'agents'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeOwnBooking($booking);

        $validated = $this->validateBooking($request, $booking);

        if (auth()->user()->isAgent()) {
            unset($validated['agent_id']);
        }

        $booking->update($validated);

        ActivityLog::record('booking_updated', "Booking #{$booking->id} updated", $booking->agency_id, 'Booking', $booking->id);

        return redirect()->route('agency.bookings.show', $booking)->with('success', 'Booking updated.');
    }

    /**
     * Bookings are never hard-deleted — payments and commissions point back
     * to them. Cancelling keeps the money trail intact without it counting
     * toward active revenue or future commission accrual.
     */
    public function cancel(Booking $booking)
    {
        $this->authorizeOwnBooking($booking);

        if (! auth()->user()->isAgencyAdmin()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        ActivityLog::record('booking_cancelled', "Booking #{$booking->id} cancelled", $booking->agency_id, 'Booking', $booking->id);

        return back()->with('success', 'Booking cancelled.');
    }

    /**
     * An agency_admin's Bookings screen must never expose another agency's
     * bookings; an agent only ever sees the ones assigned to them.
     */
    private function ownBookings()
    {
        $query = Booking::where('agency_id', auth()->user()->agency_id);

        if (auth()->user()->isAgent()) {
            $query->where('agent_id', auth()->id());
        }

        return $query;
    }

    private function authorizeOwnBooking(Booking $booking): void
    {
        abort_unless($booking->agency_id === auth()->user()->agency_id, 404);

        if (auth()->user()->isAgent()) {
            abort_unless($booking->agent_id === auth()->id(), 404);
        }
    }

    private function assignableAgents()
    {
        if (auth()->user()->isAgent()) {
            return collect([auth()->user()]);
        }

        return User::where('agency_id', auth()->user()->agency_id)->where('role', 'agent')->active()->orderBy('name')->get();
    }

    /**
     * Inquiries eligible to be turned into a booking — same agency, not
     * already linked to one, and scoped to the current agent if applicable.
     */
    private function assignableInquiries()
    {
        $linkedIds = Booking::where('agency_id', auth()->user()->agency_id)->whereNotNull('inquiry_id')->pluck('inquiry_id');

        return Inquiry::where('agency_id', auth()->user()->agency_id)
            ->whereNotIn('id', $linkedIds)
            ->orderByDesc('id')
            ->get();
    }

    private function validateBooking(Request $request, ?Booking $booking = null): array
    {
        $agencyId = auth()->user()->agency_id;

        return $request->validate([
            'inquiry_id' => ['nullable', Rule::exists('inquiries', 'id')->where('agency_id', $agencyId)],
            'agent_id' => ['nullable', Rule::exists('users', 'id')->where('agency_id', $agencyId)->where('role', 'agent')],
            'package_tier' => ['required', Rule::in(self::TIERS)],
            'total_price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'booked_at' => ['required', 'date'],
        ]);
    }
}
