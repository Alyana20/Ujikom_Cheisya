<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VendorAuthController extends Controller
{
    /**
     * Display the vendor login view.
     */
    public function showLoginForm()
    {
        // Jika sudah login sebagai vendor, redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendor.auth.login');
    }

    /**
     * Handle vendor login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Normalize email
        $email = Str::lower(trim($request->email));

        // Rate limiting
        $throttleKey = Str::transliterate(Str::lower($email) . '|' . $request->ip());
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Attempt to login
        if (Auth::attempt(['email' => $email, 'password' => $request->password], $request->boolean('remember'))) {
            
            // Check if user is vendor
            if (Auth::user()->role !== 'vendor') {
                Auth::logout();
                $request->session()->invalidate();
                
                RateLimiter::hit($throttleKey);
                
                throw ValidationException::withMessages([
                    'email' => 'Akses ditolak. Halaman ini hanya untuk Vendor.',
                ]);
            }

            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            return redirect()->intended(route('vendor.dashboard'));
        }

        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Display vendor registration form.
     */
    public function showRegisterForm()
    {
        return view('vendor.auth.register');
    }

    /**
     * Handle vendor registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_phone' => ['required', 'string', 'max:20'],
            'shop_address' => ['required', 'string', 'max:500'],
        ]);

        // Normalize email
        $email = Str::lower(trim($request->email));

        // Create user as customer first (will be upgraded to vendor after approval)
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => \Hash::make($request->password),
            'role' => 'customer', // Start as customer
            'email_verified_at' => now(),
        ]);

        // Create shop request automatically
        \App\Models\ShopRequest::create([
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_address' => $request->shop_address,
            'shop_phone' => $request->shop_phone,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Login user
        Auth::login($user);

        return redirect()->route('shop-request.show')
            ->with('success', 'Akun berhasil dibuat! Pengajuan vendor Anda sedang dalam proses review.');
    }

    /**
     * Handle vendor logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
