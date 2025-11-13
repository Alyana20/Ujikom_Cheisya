<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['quantity'] * $cart[$product->id]['price'];
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'nama' => $product->nama,
                'price' => $product->harga,
                'gambar' => $product->gambar,
                'quantity' => $quantity,
                'subtotal' => $quantity * $product->harga,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $pid = $request->product_id;

        if (isset($cart[$pid])) {
            $cart[$pid]['quantity'] = $request->quantity;
            $cart[$pid]['subtotal'] = $cart[$pid]['quantity'] * $cart[$pid]['price'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);

        $cart = session()->get('cart', []);
        $pid = $request->product_id;

        if (isset($cart[$pid])) {
            unset($cart[$pid]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }
}
