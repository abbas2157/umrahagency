<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactClick;
use App\Models\Inquiry;

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

        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentClicks = ContactClick::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentClicks'));
    }
}
