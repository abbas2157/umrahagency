<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\InquiryActivity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $agencyId = auth()->user()->agency_id;

        $systemLogs = ActivityLog::with('actor')
            ->where('agency_id', $agencyId)
            ->latest('created_at')
            ->paginate(20, ['*'], 'system_page');

        // whereHas builds its subquery against Inquiry::query(), so the
        // tenancy global scope from Foundation applies automatically —
        // an Agency Admin only ever sees activity for their own agency's
        // queries, with no extra filtering needed here.
        $queryLogs = InquiryActivity::with(['user', 'inquiry'])
            ->whereHas('inquiry')
            ->latest('created_at')
            ->paginate(20, ['*'], 'query_page');

        return view('agency.activity-log.index', compact('systemLogs', 'queryLogs'));
    }
}
