<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard - OSS Healthcare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-green-600 text-white p-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">OSS Healthcare - Vendor Panel</h1>
                    <p class="text-green-200">Halo, {{ Auth::user()->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-green-500 px-3 py-1 rounded-full">Vendor</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container mx-auto p-6">

            <!-- Status toko -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">🏪 Status Toko</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-700 p-3 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-300 text-red-700 p-3 mb-4 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($shop)
                    <div class="p-4 bg-gray-50 rounded border">
                        <p><strong>Nama Toko:</strong> {{ $shop->name }}</p>
                        <p><strong>Deskripsi:</strong> {{ $shop->description ?? '-' }}</p>
                        <p><strong>Status:</strong>
                            @if ($shop->status === 'pending')
                                <span class="text-yellow-600 font-semibold">Menunggu persetujuan</span>
                            @elseif($shop->status === 'approved')
                                <span class="text-green-600 font-semibold">Disetujui ✅</span>
                            @else
                                <span class="text-red-600 font-semibold">Ditolak ❌</span>
                            @endif
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4">
                        <p class="text-yellow-800 mb-4">Kamu belum memiliki toko.</p>
                        <a href="{{ route('vendor.shop.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            + Ajukan Buka Toko
                        </a>
                    </div>
                @endif
            </div>

            <!-- Daftar produk (placeholder sementara) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">📦 Produk Saya</h2>

                @if ($shop && $shop->status === 'approved')
                    <div class="text-gray-600">
                        <p>Daftar produk akan muncul di sini (fitur ini akan kita buat selanjutnya).</p>
                        <button class="mt-4 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                            + Tambah Produk
                        </button>
                    </div>
                @elseif($shop && $shop->status === 'pending')
                    <p class="text-yellow-600">Menunggu persetujuan toko, belum bisa menambahkan produk.</p>
                @elseif($shop && $shop->status === 'rejected')
                    <p class="text-red-600">Permohonan toko ditolak. Silakan ajukan ulang.</p>
                    <a href="{{ route('vendor.shop.create') }}" class="text-blue-600 hover:underline">Ajukan lagi</a>
                @else
                    <p class="text-gray-500">Ajukan toko terlebih dahulu untuk mulai berjualan.</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
