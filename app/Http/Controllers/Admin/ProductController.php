<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store.user', 'category']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('store', function($storeQuery) use ($search) {
                      $storeQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15);
        $categories = \App\Models\Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function ban(Product $product)
    {
        if ($product->status === 'banned') {
            return back()->with('error', 'Produk sudah dibanned sebelumnya.');
        }

        $product->update(['status' => 'banned']);

        return back()->with('success', 'Produk berhasil dibanned dan tidak akan ditampilkan di marketplace.');
    }

    public function unban(Product $product)
    {
        if ($product->status !== 'banned') {
            return back()->with('error', 'Hanya produk yang dibanned yang bisa di-unban.');
        }

        $product->update(['status' => 'active']);

        return back()->with('success', 'Produk berhasil di-unban dan akan ditampilkan kembali di marketplace.');
    }

    public function destroy(Product $product)
    {
        $productName = $product->name;
        $product->delete();

        return back()->with('success', "Produk '{$productName}' berhasil dihapus dari sistem.");
    }
}
