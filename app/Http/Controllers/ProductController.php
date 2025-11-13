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
        // Ambil 8 produk terbaru untuk featured products
        $featuredProducts = Product::with('store', 'category')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Ambil semua kategori untuk sidebar/nav
        $categories = Category::withCount('products')->get();

        return view('visitor.home', compact('featuredProducts', 'categories'));
    }

    /**
     * Halaman Semua Produk dengan Filter Kategori
     */
    public function index(Request $request)
    {
        $query = Product::with('store', 'category')
            ->where('stock', '>', 0);

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
        $categories = Category::withCount('products')->get();

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
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('products')->get();

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
