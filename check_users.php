<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== DAFTAR USER DI DATABASE ===\n\n";

$users = User::orderBy('id', 'desc')->get(['id', 'name', 'email', 'role', 'created_at']);

echo "Total users: " . $users->count() . "\n\n";
echo str_pad("ID", 5) . " | " . str_pad("Name", 25) . " | " . str_pad("Email", 30) . " | " . str_pad("Role", 10) . " | Created At\n";
echo str_repeat("-", 120) . "\n";

foreach ($users as $user) {
    echo str_pad($user->id, 5) . " | " 
        . str_pad($user->name, 25) . " | " 
        . str_pad($user->email, 30) . " | " 
        . str_pad($user->role, 10) . " | " 
        . $user->created_at . "\n";
}

echo "\n";

// Cari user dengan nama 'aqsa'
echo "=== MENCARI USER 'AQSA' ===\n";
$aqsaUser = User::where('name', 'like', '%aqsa%')->orWhere('email', 'like', '%aqsa%')->get();

if ($aqsaUser->count() > 0) {
    echo "✅ DITEMUKAN:\n";
    foreach ($aqsaUser as $u) {
        echo "   ID: {$u->id} | Name: {$u->name} | Email: {$u->email}\n";
    }
} else {
    echo "❌ TIDAK DITEMUKAN\n";
    echo "   Kemungkinan: Register gagal atau email salah\n";
}
