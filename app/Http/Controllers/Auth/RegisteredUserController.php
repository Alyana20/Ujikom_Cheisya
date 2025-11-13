<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Log request untuk debugging
        \Log::info('Registration attempt', [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Normalize email SEBELUM validasi untuk menghindari duplikasi case-sensitive
        $normalizedEmail = Str::lower(trim($request->email));
        
        $request->merge(['email' => $normalizedEmail]);
        
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                // Optional fields
                'phone' => ['nullable', 'string', 'regex:/^[0-9]{10,13}$/'],
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'in:male,female'],
                'address' => ['nullable', 'string', 'max:255'],
                'city' => ['nullable', 'string', 'max:100'],
                'postal_code' => ['nullable', 'string', 'regex:/^[0-9]{5}$/'],
            ]);

            // For visitor registration always assign 'customer' role.
            $user = User::create([
                'name' => $request->name,
                'email' => $normalizedEmail,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'email_verified_at' => now(), // Auto-verify agar langsung bisa login
                // Optional fields - only save if provided
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ]);

            \Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            event(new Registered($user));

            Auth::login($user);

            \Log::info('User logged in after registration', [
                'user_id' => $user->id,
            ]);

            // After registration, send user to the dashboard (role-aware landing).
            return redirect(route('dashboard', absolute: false));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Registration validation failed', [
                'errors' => $e->errors(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
            ])->withInput();
        }
    }
}
