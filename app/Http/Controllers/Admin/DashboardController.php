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
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'inquiries_today' => Inquiry::whereDate('created_at', today())->count(),
            'inquiries_this_week' => Inquiry::where('created_at', '>=', now()->subDays(7))->count(),
            'total_contact_clicks' => ContactClick::count(),
        ];

        $statusBreakdown = collect(Inquiry::STATUSES)->mapWithKeys(
            fn ($status) => [$status => Inquiry::where('status', $status)->count()]
        );

        $agencyStats = [
            'active_agencies' => Agency::where('is_active', true)->count(),
            'inactive_agencies' => Agency::where('is_active', false)->count(),
            'total_agents' => User::where('role', 'agent')->count(),
        ];

        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentClicks = ContactClick::latest()->take(5)->get();
        $recentActivity = ActivityLog::with('actor')->latest('created_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'statusBreakdown', 'agencyStats', 'recentInquiries', 'recentClicks', 'recentActivity'
        ));
    }
}
