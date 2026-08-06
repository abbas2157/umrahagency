<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Inquiry;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Inquiry::count()/latest() are already scoped by the global scope —
        // Agency Admin sees their own agency's queries, Agent sees only
        // their own assigned ones. Nothing extra needed here for that part.
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'inquiries_today' => Inquiry::whereDate('created_at', today())->count(),
            'inquiries_this_week' => Inquiry::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $statusBreakdown = collect(Inquiry::STATUSES)->mapWithKeys(
            fn ($status) => [$status => Inquiry::where('status', $status)->count()]
        );

        $recentInquiries = Inquiry::latest()->take(5)->get();

        // "Since your last login" needs the timestamp before this request
        // overwrites it — AdminAuthController only sets it at login time, so
        // reading it here mid-session is still the value from that login.
        $sinceLastLogin = $user->last_login_at ?? $user->created_at;

        $needsFollowUpCount = Inquiry::needsFollowUp()->count();

        if ($user->isAgencyAdmin()) {
            return $this->agencyAdminDashboard($user, $stats, $statusBreakdown, $recentInquiries, $sinceLastLogin, $needsFollowUpCount);
        }

        return $this->agentDashboard($user, $stats, $statusBreakdown, $recentInquiries, $sinceLastLogin, $needsFollowUpCount);
    }

    private function agencyAdminDashboard(User $user, array $stats, $statusBreakdown, $recentInquiries, $sinceLastLogin, int $needsFollowUpCount)
    {
        $agency = $user->agency;

        $agentRoster = User::where('agency_id', $user->agency_id)
            ->where('role', 'agent')
            ->get()
            ->map(fn (User $agent) => ['agent' => $agent, ...$agent->performanceStats()]);

        $recentActivity = ActivityLog::with('actor')
            ->where('agency_id', $user->agency_id)
            ->latest('created_at')
            ->take(5)
            ->get();

        // For an Agency Admin, "new" means "landed in my agency's queue" —
        // they don't get individually assigned queries the way an agent does.
        $newSinceLastLogin = Inquiry::where('created_at', '>=', $sinceLastLogin)->count();

        return view('agency.dashboard.agency-admin', compact(
            'agency', 'stats', 'statusBreakdown', 'recentInquiries', 'agentRoster', 'recentActivity',
            'newSinceLastLogin', 'needsFollowUpCount'
        ));
    }

    private function agentDashboard(User $user, array $stats, $statusBreakdown, $recentInquiries, $sinceLastLogin, int $needsFollowUpCount)
    {
        $agency = $user->agency;
        $branch = $user->branch;

        $resolvedThisWeek = Inquiry::where('created_at', '>=', now()->subDays(7))
            ->whereIn('status', ['booked', 'lost', 'junk'])
            ->count();

        $performance = $user->performanceStats();

        $newSinceLastLogin = Inquiry::where('assigned_agent_id', $user->id)->where('assigned_at', '>=', $sinceLastLogin)->count();

        return view('agency.dashboard.agent', compact(
            'agency', 'branch', 'stats', 'statusBreakdown', 'recentInquiries', 'resolvedThisWeek', 'performance',
            'newSinceLastLogin', 'needsFollowUpCount'
        ));
    }
}
