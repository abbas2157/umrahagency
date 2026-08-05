<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\ContactClick;
use App\Models\Inquiry;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Inquiry::count()/latest() are already scoped to the current role
        // by the global scope on the model — Agents only ever see their own
        // assigned queries, Agency Admins only their agency's.
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'inquiries_today' => Inquiry::whereDate('created_at', today())->count(),
            'inquiries_this_week' => Inquiry::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $statusBreakdown = collect(Inquiry::STATUSES)->mapWithKeys(
            fn ($status) => [$status => Inquiry::where('status', $status)->count()]
        );

        $recentInquiries = Inquiry::latest()->take(5)->get();

        $recentClicks = collect();
        $agencyStats = null;
        $recentActivity = collect();

        if ($user->isSuperAdmin()) {
            $stats['total_contact_clicks'] = ContactClick::count();
            $recentClicks = ContactClick::latest()->take(5)->get();

            $agencyStats = [
                'active_agencies' => Agency::where('is_active', true)->count(),
                'inactive_agencies' => Agency::where('is_active', false)->count(),
                'total_agents' => User::where('role', 'agent')->count(),
            ];

            $recentActivity = ActivityLog::with('actor')->latest('created_at')->take(5)->get();
        } elseif ($user->isAgencyAdmin()) {
            $agencyStats = [
                'total_agents' => User::where('role', 'agent')->where('agency_id', $user->agency_id)->count(),
            ];

            $recentActivity = ActivityLog::with('actor')
                ->where('agency_id', $user->agency_id)
                ->latest('created_at')
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'stats', 'statusBreakdown', 'recentInquiries', 'recentClicks', 'agencyStats', 'recentActivity'
        ));
    }
}
