<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;

                // Arahkan sesuai peran (role) user
                switch ($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'vendor':
                        return redirect()->route('vendor.dashboard');
                    case 'customer':
                        return redirect()->route('dashboard');
                    default:
                        return redirect()->route('home');
                }
            }
        }

        // Kalau belum login, lanjutkan request normal (bisa buka /login)
        return $next($request);
    }
}
