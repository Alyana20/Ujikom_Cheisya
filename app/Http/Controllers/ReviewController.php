<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store review untuk produk
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah review produk ini (satu user hanya bisa review satu kali per produk)
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'approved' => false, // pending approval dari admin
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim. Menunggu persetujuan admin.');
    }

    /**
     * Delete review (user sendiri atau admin)
     * @param Review $review
     */
    public function destroy(Review $review)
    {
        // Only allow the owner or an authenticated admin to delete a review
        if (Auth::id() !== $review->user_id && !(Auth::check() && Auth::user()->role === 'admin')) {
            abort(403, 'Tidak bisa menghapus review orang lain.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }

    /**
     * Admin approve review
     * @param Review $review
     */
    public function approve(Review $review)
    {
        $review->update(['approved' => true]);

        return redirect()->back()->with('success', 'Review disetujui.');
    }

    /**
     * Admin reject review
     * @param Review $review
     */
    public function reject(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review ditolak.');
    }
}
