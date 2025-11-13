<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of vendor's products.
     */
    public function index()
    {
        // Get vendor's store
        $store = Store::where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda harus memiliki toko terlebih dahulu.');
        }

        // Get products for this store
        $products = Product::where('store_id', $store->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        // Get stats
        $stats = [
            'total' => Product::where('store_id', $store->id)->count(),
            'active' => Product::where('store_id', $store->id)->where('status', 'active')->count(),
            'low_stock' => Product::where('store_id', $store->id)->where('stock', '<', 10)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('store_id', $store->id)->where('stock', 0)->count(),
        ];

        return view('vendor.products.index', compact('products', 'store', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda harus memiliki toko terlebih dahulu.');
        }

        $categories = Category::all();
        
        return view('vendor.products.create', compact('categories', 'store'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Anda harus memiliki toko terlebih dahulu.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create product with English column names
        Product::create([
            'store_id' => $store->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        // Verify this product belongs to vendor's store
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        // Verify this product belongs to vendor's store
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        // Verify this product belongs to vendor's store
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Prepare update data with English column names
        $data = [
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        // Verify this product belongs to vendor's store
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product)
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        // Verify this product belongs to vendor's store
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return back()->with('success', 'Status produk berhasil diubah!');
    }
}
