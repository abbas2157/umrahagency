<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\InquiryActivity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $systemLogs = ActivityLog::with('actor')
            ->when(! $user->isSuperAdmin(), fn ($query) => $query->where('agency_id', $user->agency_id))
            ->latest('created_at')
            ->paginate(20, ['*'], 'system_page');

        // whereHas builds its subquery against Inquiry::query(), so the
        // tenancy global scope from Foundation applies here automatically —
        // an Agency Admin only ever sees activity for their own agency's
        // queries, with no extra filtering needed in this controller.
        $queryLogs = InquiryActivity::with(['user', 'inquiry'])
            ->whereHas('inquiry')
            ->latest('created_at')
            ->paginate(20, ['*'], 'query_page');

        return view('admin.activity-log.index', compact('systemLogs', 'queryLogs'));
    }
}
