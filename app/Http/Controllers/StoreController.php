<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Vendor membuat store
    public function create()
    {
        // Check if user already has a store
        $store = Store::where('user_id', Auth::id())->first();
        
        return view('vendor.store.create', compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Toko berhasil diajukan, menunggu persetujuan admin.');
    }

    // Admin melihat semua store
    public function index()
    {
        $stores = Store::with('user')->latest()->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }

    // Admin menyetujui store
    public function approve(Store $store)
    {
        $store->update(['status' => 'approved']);
        return back()->with('success', 'Toko telah disetujui.');
    }

    // Admin menolak store
    public function reject(Store $store)
    {
        $store->update(['status' => 'rejected']);
        return back()->with('success', 'Toko telah ditolak.');
    }
}
