<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\InquiryActivity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $systemLogs = ActivityLog::with('actor')
            ->latest('created_at')
            ->paginate(20, ['*'], 'system_page');

        $queryLogs = InquiryActivity::with(['user', 'inquiry'])
            ->whereHas('inquiry')
            ->latest('created_at')
            ->paginate(20, ['*'], 'query_page');

        return view('admin.activity-log.index', compact('systemLogs', 'queryLogs'));
    }
}
