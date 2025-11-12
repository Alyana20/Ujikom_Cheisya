<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Halaman Homepage untuk Visitor
     */
    public function home()
    {
        // Ambil 8 produk terbaru untuk featured products
        $featuredProducts = Product::with('store')
            ->where('stok', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('visitor.home', compact('featuredProducts')); // ✅ UPDATE: 'visitor.home'
    }

    /**
     * Halaman Semua Produk
     */
    public function index()
    {
        $products = Product::with('store')
            ->where('stok', '>', 0)
            ->latest()
            ->paginate(12);

        return view('visitor.products.index', compact('products')); // ✅ UPDATE: 'visitor.products.index'
    }

    /**
     * Halaman Detail Produk
     */
    public function show(Product $product)
    {
        return view('visitor.products.show', compact('product')); // ✅ UPDATE: 'visitor.products.show'
    }
}
