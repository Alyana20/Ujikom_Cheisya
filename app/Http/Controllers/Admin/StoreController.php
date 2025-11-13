<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $stores = $query->latest()->paginate(10);

        return view('admin.stores.index', compact('stores'));
    }

    public function approve(Store $store)
    {
        if ($store->status === 'approved') {
            return back()->with('error', 'Toko sudah disetujui sebelumnya.');
        }

        $store->update(['status' => 'approved']);

        // Update user role menjadi vendor
        $store->user->update(['role' => 'vendor']);

        return back()->with('success', 'Toko berhasil disetujui! User sekarang menjadi vendor.');
    }

    public function reject(Store $store)
    {
        if ($store->status === 'rejected') {
            return back()->with('error', 'Toko sudah ditolak sebelumnya.');
        }

        $store->update(['status' => 'rejected']);

        return back()->with('success', 'Toko berhasil ditolak.');
    }

    public function toggleActive(Store $store)
    {
        if ($store->status !== 'approved' && $store->status !== 'inactive') {
            return back()->with('error', 'Hanya toko yang sudah disetujui yang bisa diaktifkan/nonaktifkan.');
        }

        // Toggle between approved (active) and inactive
        $newStatus = $store->status === 'approved' ? 'inactive' : 'approved';
        $store->update(['status' => $newStatus]);

        $message = $newStatus === 'inactive' 
            ? 'Toko berhasil dinonaktifkan.' 
            : 'Toko berhasil diaktifkan.';

        return back()->with('success', $message);
    }
}
