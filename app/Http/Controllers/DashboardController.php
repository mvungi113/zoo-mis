<?php

namespace App\Http\Controllers;

use App\Models\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the latest logs
        $logs = Log::latest()->take(10)->get();

        return view('dashboard', compact('logs'));
    }
}
