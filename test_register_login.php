<?php

/**
 * Script untuk test Register dan Login
 * Jalankan dengan: php test_register_login.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

echo "=== TEST REGISTER & LOGIN ===\n\n";

// Test 1: Simulasi Register
echo "1️⃣ SIMULASI REGISTER\n";
$testEmail = 'testuser' . time() . '@gmail.com';
$testPassword = '12345678';
$testName = 'Test User ' . date('H:i:s');

echo "   Creating user with:\n";
echo "   - Name: {$testName}\n";
echo "   - Email: {$testEmail}\n";
echo "   - Password: {$testPassword}\n";

$normalizedEmail = Str::lower(trim($testEmail));

$user = User::create([
    'name' => $testName,
    'email' => $normalizedEmail,
    'password' => Hash::make($testPassword),
    'role' => 'customer',
    'email_verified_at' => now(),
]);

echo "   ✅ User created successfully! ID: {$user->id}\n\n";

// Test 2: Simulasi Login
echo "2️⃣ SIMULASI LOGIN\n";
echo "   Trying to login with:\n";
echo "   - Email: {$testEmail}\n";
echo "   - Password: {$testPassword}\n";

// Normalize email seperti di LoginRequest
$loginEmail = Str::lower(trim($testEmail));

$credentials = [
    'email' => $loginEmail,
    'password' => $testPassword,
];

if (Auth::attempt($credentials)) {
    echo "   ✅ LOGIN BERHASIL!\n";
    echo "   - User ID: " . Auth::user()->id . "\n";
    echo "   - Name: " . Auth::user()->name . "\n";
    echo "   - Email: " . Auth::user()->email . "\n";
    echo "   - Role: " . Auth::user()->role . "\n\n";
} else {
    echo "   ❌ LOGIN GAGAL!\n\n";
}

// Test 3: Verifikasi password hash
echo "3️⃣ VERIFIKASI PASSWORD HASH\n";
$storedUser = User::where('email', $normalizedEmail)->first();
echo "   - Email di DB: {$storedUser->email}\n";
echo "   - Password Hash: " . substr($storedUser->password, 0, 20) . "...\n";
echo "   - Hash Check: " . (Hash::check($testPassword, $storedUser->password) ? '✅ MATCH' : '❌ NOT MATCH') . "\n\n";

// Test 4: Test case-insensitive email
echo "4️⃣ TEST CASE-INSENSITIVE EMAIL\n";
$upperEmail = strtoupper($testEmail);
echo "   Trying login with UPPERCASE email: {$upperEmail}\n";

$upperLoginEmail = Str::lower(trim($upperEmail));
if (Auth::attempt(['email' => $upperLoginEmail, 'password' => $testPassword])) {
    echo "   ✅ CASE-INSENSITIVE LOGIN BERHASIL!\n\n";
} else {
    echo "   ❌ CASE-INSENSITIVE LOGIN GAGAL!\n\n";
}

echo "=== TEST SELESAI ===\n";
echo "Silakan coba register dan login di browser!\n";
