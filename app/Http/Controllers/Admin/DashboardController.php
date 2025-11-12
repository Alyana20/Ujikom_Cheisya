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
            'total_vendors' => User::where('role', 'vendor')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_stores' => Store::where('status', 'pending')->count(),
            'total_products' => 0, // Nanti diganti jika sudah ada model Product
            'pending_store_requests' => Store::with('user')
                ->where('status', 'pending')
                ->latest()
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
