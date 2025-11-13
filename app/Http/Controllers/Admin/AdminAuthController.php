<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function showLoginForm()
    {
        // Jika sudah login sebagai admin, redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login request.
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
            
            // Check if user is admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                $request->session()->invalidate();
                
                RateLimiter::hit($throttleKey);
                
                throw ValidationException::withMessages([
                    'email' => 'Akses ditolak. Halaman ini hanya untuk Admin.',
                ]);
            }

            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
