<?php

namespace App\Support;

use App\Models\Agency;
use App\Models\City;
use App\Models\Inquiry;
use App\Models\InquiryActivity;

class InquiryRouter
{
    /**
     * Auto-assigns a freshly submitted query to an agency, matching its
     * departure_airport against a City name (the form is frozen — this is
     * the closest location signal it already collects, no new field
     * needed). No match, or no agency covering that city, leaves the query
     * unassigned — it shows up in the "Needs Routing" list for Super Admin
     * to hand-assign instead. Multiple covering agencies split the load by
     * picking whichever currently has the fewest assigned queries, so the
     * same agency doesn't always win.
     */
    public static function route(Inquiry $inquiry): void
    {
        if ($inquiry->agency_id || ! $inquiry->departure_airport) {
            return;
        }

        $city = City::where('is_active', true)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($inquiry->departure_airport))])
            ->first();

        if (! $city) {
            return;
        }

        $agency = $city->agencies()
            ->where('agencies.is_active', true)
            ->withCount('inquiries')
            ->orderBy('inquiries_count')
            ->orderBy('agencies.id')
            ->first();

        if (! $agency) {
            return;
        }

        $inquiry->update([
            'agency_id' => $agency->id,
            'assigned_at' => now(),
        ]);

        InquiryActivity::record($inquiry, 'assignment', 'Unassigned', $agency->name, 'Auto-routed by city');
    }
}
