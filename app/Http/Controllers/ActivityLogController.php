<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog; // ✅ WAJIB

class ActivityLogController extends Controller // ✅ FIX NAMA
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        return view('activity_logs.index', compact('logs'));
    }
}