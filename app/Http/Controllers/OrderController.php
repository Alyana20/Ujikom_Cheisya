<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Customer lihat order history
     */
    public function index()
    {
        // Use Order query by user_id to avoid relying on a loaded User relation
        // (safer if called in contexts where the user model isn't fully present).
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Customer lihat detail order
     */
    public function show(Order $order)
    {
        // Ensure the current user is either the owner of the order or an admin.
        if ($order->user_id !== Auth::id() && !(Auth::check() && Auth::user()->role === 'admin')) {
            abort(403);
        }

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Customer cancel order (sebelum dikirim)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->canCancel()) {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        DB::beginTransaction();
        try {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibatalkan. Stok produk telah dipulihkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Admin mark shipped
     */
    public function markShipped(Order $order)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        if (!$order->isPaid() && $order->payment_method !== 'cod') {
            return redirect()->back()->with('error', 'Pesanan harus dibayar dulu sebelum dikirim.');
        }

        $order->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan ditandai sebagai dikirim.');
    }

    /**
     * Admin mark delivered
     */
    public function markDelivered(Order $order)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan ditandai sebagai terkirim.');
    }

    /**
     * Admin view all orders
     */
    public function adminIndex()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Admin view order detail
     */
    public function adminShow(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Download invoice untuk pesanan yang sudah selesai
     */
    public function downloadInvoice(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan pesanan sudah delivered
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Invoice hanya tersedia untuk pesanan yang sudah terkirim.');
        }

        $order->load('user', 'items.product.store');

        $pdf = Pdf::loadView('customer.orders.invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
