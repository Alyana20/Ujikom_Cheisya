<?php

namespace App\Http\Controllers;

use App\Models\ShopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman form untuk apply jadi vendor
     */
    public function create()
    {
        $existingRequest = Auth::user()->shopRequest;

        return view('vendor.shop-request.create', compact('existingRequest'));
    }

    /**
     * Submit shop application
     */
    public function store(Request $request)
    {
        // Cek apakah user sudah punya request yg pending/approved
        $existing = Auth::user()->shopRequest;
        if ($existing && ($existing->isPending() || $existing->isApproved())) {
            return redirect()->route('shop-request.show')
                ->with('error', 'Anda sudah memiliki aplikasi toko yang aktif.');
        }

        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:1000',
            'shop_address' => 'required|string|max:500',
            'shop_phone' => 'required|string|max:20',
        ]);

        ShopRequest::create([
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_address' => $request->shop_address,
            'shop_phone' => $request->shop_phone,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()->route('shop-request.show')
            ->with('success', 'Aplikasi toko berhasil dikirim. Tunggu persetujuan admin.');
    }

    /**
     * Lihat status aplikasi
     */
    public function show()
    {
        $shopRequest = Auth::user()->shopRequest;

        if (!$shopRequest) {
            return redirect()->route('shop-request.create');
        }

        return view('vendor.shop-request.show', compact('shopRequest'));
    }

    /**
     * Edit aplikasi (jika rejected atau pending)
     */
    public function edit()
    {
        $shopRequest = Auth::user()->shopRequest;

        if (!$shopRequest || $shopRequest->isApproved()) {
            abort(403, 'Tidak bisa mengedit aplikasi yang sudah disetujui.');
        }

        return view('vendor.shop-request.edit', compact('shopRequest'));
    }

    /**
     * Update aplikasi
     */
    public function update(Request $request)
    {
        $shopRequest = Auth::user()->shopRequest;

        if (!$shopRequest) {
            abort(404);
        }

        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:1000',
            'shop_address' => 'required|string|max:500',
            'shop_phone' => 'required|string|max:20',
        ]);

        $shopRequest->update([
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_address' => $request->shop_address,
            'shop_phone' => $request->shop_phone,
        ]);

        return redirect()->route('shop-request.show')
            ->with('success', 'Aplikasi toko berhasil diperbarui.');
    }
}
