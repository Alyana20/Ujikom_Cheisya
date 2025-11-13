<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorOrderController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda belum memiliki toko. Silakan buat toko terlebih dahulu.');
        }

        $orders = Order::whereHas('items.product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })
        ->with(['user', 'items' => function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            })->with('product');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        $stats = [
            'total' => Order::whereHas('items.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })->count(),
            
            'pending' => Order::whereHas('items.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })->whereIn('status', ['pending', 'paid'])->count(),
            
            'processing' => Order::whereHas('items.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })->where('status', 'processing')->count(),
            
            'shipped' => Order::whereHas('items.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })->where('status', 'shipped')->count(),
        ];

        return view('vendor.orders.index', compact('orders', 'stats'));
    }

    public function show($id)
    {
        $store = Store::where('user_id', auth()->id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $order = Order::whereHas('items.product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })
        ->with([
            'user', 
            'items' => function($query) use ($store) {
                $query->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                });
            },
            'items.product'
        ])
        ->findOrFail($id);

        return view('vendor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $store = Store::where('user_id', auth()->id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $order = Order::whereHas('items.product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })->findOrFail($id);

        $request->validate([
            'status' => 'required|in:processing,shipped,delivered'
        ]);

        // Validasi: hanya bisa update jika COD atau sudah dibayar (paid)
        if ($order->payment_method !== 'cod' && $order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Status pesanan hanya dapat diubah untuk pesanan COD atau pesanan yang sudah dibayar.');
        }

        // Validasi: tidak bisa update jika pesanan dibatalkan
        if ($order->status === 'cancelled') {
            return redirect()->back()->with('error', 'Status pesanan yang dibatalkan tidak dapat diubah.');
        }

        // Validasi: tidak bisa update jika sudah delivered
        if ($order->status === 'delivered') {
            return redirect()->back()->with('error', 'Status pesanan yang sudah selesai tidak dapat diubah.');
        }

        $updateData = ['status' => $request->status];

        // Set timestamp sesuai status
        if ($request->status === 'shipped') {
            $updateData['shipped_at'] = now();
        } elseif ($request->status === 'delivered') {
            $updateData['delivered_at'] = now();
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $this->getStatusLabel($request->status) . '.');
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Sedang Dikirim',
            'delivered' => 'Sudah Terkirim',
            'cancelled' => 'Dibatalkan',
            'paid' => 'Dibayar'
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}
