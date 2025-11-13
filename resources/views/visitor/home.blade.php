@extends('layouts.marketplace')

@section('content')
    <!-- Hero Section -->
    <section class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Toko Alat Kesehatan Terpercaya</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Temukan berbagai alat kesehatan, obat, dan suplemen berkualitas dengan harga terbaik
                </p>
                <a href="{{ route('products.index') }}"
                    class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300 inline-block">
                    <i class="fas fa-shopping-cart mr-2"></i>Belanja Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Gratis Ongkir</h3>
                    <p class="text-gray-600">Gratis pengiriman untuk pembelian di atas Rp 500.000</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Produk Asli</h3>
                    <p class="text-gray-600">100% produk original dengan garansi resmi</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Bantuan 24/7</h3>
                    <p class="text-gray-600">Customer service siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Kategori Produk</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ([['icon' => 'fas fa-pills', 'name' => 'Obat', 'color' => 'blue'], ['icon' => 'fas fa-capsules', 'name' => 'Suplemen', 'color' => 'green'], ['icon' => 'fas fa-stethoscope', 'name' => 'Alat Terapi', 'color' => 'purple'], ['icon' => 'fas fa-medkit', 'name' => 'Peralatan Medis', 'color' => 'red']] as $category)
                    <a href="{{ route('products.index') }}?category={{ $category['name'] }}"
                        class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300 hover:transform hover:-translate-y-1">
                        <div
                            class="bg-{{ $category['color'] }}-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $category['icon'] }} text-{{ $category['color'] }}-600 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $category['name'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Produk Terpopuler</h2>
                    <p class="text-gray-600 mt-2">Pilihan terbaik dari toko kami</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if ($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($featuredProducts as $product)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <div class="h-48 bg-gray-200 overflow-hidden">
                                    @if ($product->gambar)
                                        <img src="{{ $product->gambar }}" alt="{{ $product->nama }}"
                                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            @if ($product->kategori == 'Obat')
                                                <i class="fas fa-pills text-gray-400 text-4xl"></i>
                                            @elseif($product->kategori == 'Suplemen')
                                                <i class="fas fa-capsules text-gray-400 text-4xl"></i>
                                            @elseif($product->kategori == 'Alat Terapi')
                                                <i class="fas fa-stethoscope text-gray-400 text-4xl"></i>
                                            @else
                                                <i class="fas fa-medkit text-gray-400 text-4xl"></i>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold mb-3">
                                    {{ $product->kategori }}
                                </span>

                                <!-- Product Name -->
                                <a href="{{ route('products.show', $product) }}" class="hover:text-blue-600 block mb-2">
                                    <h3 class="font-semibold text-lg line-clamp-2">{{ $product->nama }}</h3>
                                </a>

                                <!-- Price -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-blue-600 font-bold text-xl">Rp
                                        {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    @if ($product->stok > 0)
                                        <span class="text-green-600 text-sm font-medium">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="text-red-500 text-sm font-medium">
                                            <i class="fas fa-times-circle"></i> Habis
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-blue-700 transition duration-200 text-center">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>

                                    @auth
                                        @if ($product->stok > 0)
                                            <button
                                                class="bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-green-700 transition duration-200">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        @else
                                            <button disabled
                                                class="bg-gray-400 text-white py-2 px-4 rounded-lg text-sm font-semibold cursor-not-allowed">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="bg-gray-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-gray-700 transition duration-200">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600">Belum ada produk</h3>
                    <p class="text-gray-500 mt-2">Produk akan segera tersedia</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Butuh Bantuan?</h2>
            <p class="text-xl mb-8">Tim customer service kami siap membantu Anda 24/7</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/6281234567890"
                    class="bg-green-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-600 transition duration-300 inline-flex items-center justify-center">
                    <i class="fab fa-whatsapp text-xl mr-2"></i> Chat WhatsApp
                </a>
                <a href="tel:+6281234567890"
                    class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 inline-flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
