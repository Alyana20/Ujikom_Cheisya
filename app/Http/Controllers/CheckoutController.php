<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        return view('checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|string|in:cod',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $total = array_sum(array_column($cart, 'subtotal'));

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if (!$product || $product->stok < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi untuk produk: ' . ($item['nama'] ?? ''));
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->harga,
                    'subtotal' => $item['subtotal'],
                ]);

                // decrement stock
                $product->decrement('stok', $item['quantity']);
            }

            DB::commit();

            // clear cart
            session()->forget('cart');

            return redirect()->route('orders.confirmation', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        // ensure owner
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.confirmation', compact('order'));
    }
}
