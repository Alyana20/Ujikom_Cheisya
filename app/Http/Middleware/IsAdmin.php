<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ⬅️ Tambahkan ini!
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan Auth::check() untuk memastikan user login
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, tampilkan error 403
        abort(403, 'Unauthorized access.');

        return response('Unauthorized', 403);
    }
}
