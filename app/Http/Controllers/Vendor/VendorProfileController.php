<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Store;

class VendorProfileController extends Controller
{
    /**
     * Display the vendor profile management page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized access');
        }
        
        // Get vendor's store
        $store = Store::where('user_id', $user->id)->first();
        
        return view('vendor.profile.index', compact('user', 'store'));
    }
    
    /**
     * Show the form for editing vendor profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Check if user is vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized access');
        }
        
        // Get vendor's store
        $store = Store::where('user_id', $user->id)->first();
        
        return view('vendor.profile.edit', compact('user', 'store'));
    }
    
    /**
     * Update vendor's personal information.
     */
    public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized access');
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
        ]);
        
        return redirect()->route('vendor.profile.index')
            ->with('success', 'Profil personal berhasil diperbarui!');
    }
    
    /**
     * Update vendor's store information.
     */
    public function updateStore(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized access');
        }
        
        $store = Store::where('user_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
        ]);
        
        $store->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);
        
        return redirect()->route('vendor.profile.index')
            ->with('success', 'Informasi toko berhasil diperbarui!');
    }
    
    /**
     * Update vendor's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized access');
        }
        
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('vendor.profile.index')
            ->with('success', 'Password berhasil diubah!');
    }
}
