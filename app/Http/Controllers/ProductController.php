<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Halaman Homepage untuk Visitor
     */
    public function home()
    {
        // Ambil 8 produk terbaru untuk featured products dari toko yang approved
        $featuredProducts = Product::with('store', 'category')
            ->where('stock', '>', 0)
            ->where('status', 'active')
            ->whereHas('store', function($query) {
                $query->where('status', 'approved');
            })
            ->latest()
            ->take(8)
            ->get();

        // Ambil hanya kategori yang memiliki produk aktif dari toko approved
        $categories = Category::whereHas('products', function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        })->withCount(['products' => function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        }])->get();

        return view('visitor.home', compact('featuredProducts', 'categories'));
    }

    /**
     * Halaman Semua Produk dengan Filter Kategori
     */
    public function index(Request $request)
    {
        $query = Product::with('store', 'category')
            ->where('stock', '>', 0)
            ->where('status', 'active')
            ->whereHas('store', function($q) {
                $q->where('status', 'approved');
            });

        // Filter by category jika ada parameter
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
            $selectedCategory = $category;
        } else {
            $selectedCategory = null;
        }

        // Search by product name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        
        // Hanya tampilkan kategori yang memiliki produk
        $categories = Category::whereHas('products', function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        })->withCount(['products' => function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        }])->get();

        return view('visitor.products.index', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Browse by Category
     */
    public function byCategory(Category $category)
    {
        $products = Product::with('store', 'category')
            ->where('category_id', $category->id)
            ->where('stock', '>', 0)
            ->where('status', 'active')
            ->whereHas('store', function($query) {
                $query->where('status', 'approved');
            })
            ->latest()
            ->paginate(12);

        // Hanya tampilkan kategori yang memiliki produk
        $categories = Category::whereHas('products', function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        })->withCount(['products' => function($query) {
            $query->where('status', 'active')
                  ->where('stock', '>', 0)
                  ->whereHas('store', function($q) {
                      $q->where('status', 'approved');
                  });
        }])->get();

        return view('visitor.products.category', compact('category', 'products', 'categories'));
    }

    /**
     * Halaman Detail Produk
     */
    public function show(Product $product)
    {
        // Load relationships
        $product->load(['category', 'store']);
        
        // Get related products based on category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->where('status', 'active')
            ->with(['store', 'category'])
            ->take(4)
            ->get();

        return view('visitor.products.show', compact('product', 'relatedProducts'));
    }
}
