<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopRequestApprovalController extends Controller
{
    public function __construct()
    {
        // This middleware is applied via routes
    }

    /**
     * Admin halaman untuk review shop requests
     */
    public function index(Request $request)
    {
        $query = ShopRequest::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $shopRequests = $query->latest('submitted_at')->paginate(15);
        $statuses = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];

        return view('admin.shop-requests.index', compact('shopRequests', 'statuses'));
    }

    /**
     * Admin lihat detail request
     */
    public function show(ShopRequest $shopRequest)
    {
        return view('admin.shop-requests.show', compact('shopRequest'));
    }

    /**
     * Admin approve shop request
     */
    public function approve(ShopRequest $shopRequest)
    {
        if ($shopRequest->isApproved()) {
            return redirect()->back()->with('error', 'Aplikasi sudah disetujui sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // Update shop request status
            $shopRequest->update([
                'status' => 'approved',
                'approved_at' => now(),
                'rejection_reason' => null,
            ]);

            // Change user role to vendor
            $shopRequest->user->update(['role' => 'vendor']);

            // Create store for vendor if not exists
            if (!$shopRequest->user->store) {
                $shopRequest->user->store()->create([
                    'name' => $shopRequest->shop_name,
                    'description' => $shopRequest->shop_description,
                    'address' => $shopRequest->shop_address,
                    'status' => 'approved',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.shop-requests.index')
                ->with('success', "Toko '{$shopRequest->shop_name}' berhasil disetujui. User sekarang menjadi vendor.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Admin reject shop request
     */
    public function reject(Request $request, ShopRequest $shopRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($shopRequest->isApproved()) {
            return redirect()->back()->with('error', 'Tidak bisa menolak aplikasi yang sudah disetujui.');
        }

        $shopRequest->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.shop-requests.index')
            ->with('success', "Aplikasi toko '{$shopRequest->shop_name}' ditolak.");
    }

    /**
     * Admin reopen (change rejected to pending)
     */
    public function reopen(ShopRequest $shopRequest)
    {
        if (!$shopRequest->isRejected()) {
            return redirect()->back()->with('error', 'Hanya aplikasi yang ditolak yang bisa dibuka kembali.');
        }

        $shopRequest->update([
            'status' => 'pending',
            'rejection_reason' => null,
            'rejected_at' => null,
        ]);

        return redirect()->route('admin.shop-requests.index')
            ->with('success', "Aplikasi toko dibuka kembali untuk review.");
    }
}
