<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin Dashboard.
     *
     * @return view
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
