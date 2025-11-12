<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('vendor.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat akun vendor
        $vendor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor', // ⬅️ Pastikan kolom 'role' sudah ada di tabel users
        ]);

        Auth::login($vendor);

        return redirect()->route('vendor.dashboard');
    }

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Pastikan yang login cuma vendor
        if (Auth::attempt(array_merge($credentials, ['role' => 'vendor']))) {
            return redirect()->route('vendor.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid vendor credentials.']);
    }
}
