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
        return view('vendor.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
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
