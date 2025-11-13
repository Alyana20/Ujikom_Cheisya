<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.store', 'product.category'])
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('customer.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            
            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cart->product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Keranjang dikosongkan');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.store', 'product.category'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $total = $cartItems->sum('subtotal');

        return view('customer.cart.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod,midtrans',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $itemsByStore = $cartItems->groupBy('product.store_id');
        $createdOrders = [];

        DB::beginTransaction();
        try {
            foreach ($itemsByStore as $storeId => $items) {
                $subtotal = $items->sum('subtotal');

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'store_id' => $storeId,
                    'order_number' => 'ORD-' . time() . '-' . $storeId,
                    'subtotal' => $subtotal,
                    'shipping_cost' => 0,
                    'total_amount' => $subtotal,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'unpaid',
                    'shipping_address' => $request->shipping_address,
                    'phone' => $request->phone,
                    'notes' => $request->notes,
                ]);

                foreach ($items as $item) {
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception('Stok ' . $item->product->name . ' tidak mencukupi');
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->subtotal,
                    ]);

                    $item->product->decrement('stock', $item->quantity);
                }

                $createdOrders[] = $order;
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // If payment method is Midtrans, redirect to payment page
            if ($request->payment_method === 'midtrans') {
                // Use first order for payment (in case of multiple stores)
                $mainOrder = $createdOrders[0];
                
                try {
                    $midtransService = new MidtransService();
                    $snapToken = $midtransService->createTransaction($mainOrder);
                    
                    $mainOrder->update(['snap_token' => $snapToken]);
                    
                    return view('customer.payment.midtrans', compact('mainOrder', 'snapToken'));
                } catch (\Exception $e) {
                    return redirect()->route('orders.show', $mainOrder->id)
                        ->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
                }
            }

            // COD - redirect to orders
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
