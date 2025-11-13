<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_vendors' => User::where('role', 'vendor')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_stores' => Store::count(),
            'pending_stores' => Store::where('status', 'pending')->count(),
            'approved_stores' => Store::where('status', 'approved')->count(),
            'total_products' => \App\Models\Product::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
