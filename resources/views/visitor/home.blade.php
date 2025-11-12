@extends('layouts.marketplace')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Hero Section -->
        <section class="bg-blue-600 text-white rounded-2xl p-8 mb-12">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang di Toko Alat Kesehatan Terpercaya</h1>
                <p class="text-xl mb-6">Temukan berbagai alat kesehatan berkualitas dengan harga terbaik</p>
                <a href="{{ route('products.index') }}"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    Belanja Sekarang
                </a>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Kategori Produk</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach (['Alat Monitoring', 'Alat Bantu Jalan', 'Alat Terapi', 'Peralatan Medis'] as $category)
                    <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition-shadow">
                        <i class="fas fa-heartbeat text-3xl text-blue-600 mb-3"></i>
                        <h3 class="font-semibold">{{ $category }}</h3>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Featured Products -->
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Produk Terpopuler</h2>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Lihat Semua Produk →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Product Image -->
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if ($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                                    class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-box text-gray-400 text-4xl"></i>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $product->nama }}</h3>
                            <p class="text-gray-600 text-sm mb-3">
                                {{ \Illuminate\Support\Str::limit($product->deskripsi, 60) }}
                            </p>

                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-bold">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</span>

                                @auth
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
