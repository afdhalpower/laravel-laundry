<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('actor')->latest('id');

        // Filter by action type
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by subject type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'App\\Models\\' . $request->subject_type);
        }

        $logs = $query->paginate(20);

        $actionTypes = ['created', 'updated', 'deleted'];
        $subjectTypes = ['Order', 'Customer', 'Payment', 'Service'];

        return view('activity-logs.index', compact('logs', 'actionTypes', 'subjectTypes'));
    }
}
