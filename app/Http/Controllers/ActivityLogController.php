<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        // hanya admin yang boleh lihat log
        $this->middleware('role:admin');
    }

public function index(Request $request)
{
    $query = ActivityLog::with('user');

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Filter action
    if ($request->filled('action')) {
        $query->where('action', $request->action);
    }

    if ($request->filled('user')) {
        $query->where('user_id', $request->user);
    }

    $logs = $query->latest()->paginate(15)->withQueryString();

    $users = User::select('id', 'name')->get();

    return view('activity_logs.index', compact('logs', 'users'));
}
}