<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;

class SecurityDashboardController extends Controller
{
    public function index()
    {
        return view('security.dashboard');
    }
}