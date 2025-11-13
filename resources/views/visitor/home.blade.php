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
                @php
                    $colors = ['blue', 'green', 'purple', 'red', 'yellow', 'pink', 'indigo', 'teal'];
                @endphp
                @forelse ($categories as $category)
                    @php
                        $colorIndex = $loop->index % count($colors);
                        $color = $colors[$colorIndex];
                    @endphp
                    <a href="{{ route('products.byCategory', $category->slug) }}"
                        class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow duration-300 hover:transform hover:-translate-y-1">
                        <div class="bg-{{ $color }}-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            @if($category->icon && mb_strlen($category->icon) <= 2)
                                {{-- Emoji icon --}}
                                <span class="text-4xl">{{ $category->icon }}</span>
                            @else
                                {{-- FontAwesome icon or default --}}
                                <i class="{{ $category->icon ?? 'fas fa-tag' }} text-{{ $color }}-600 text-3xl"></i>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h3>
                        @if($category->products_count > 0)
                            <p class="text-sm text-gray-500 mt-1">{{ $category->products_count }} produk</p>
                        @endif
                    </a>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Belum ada kategori dengan produk tersedia</p>
                    </div>
                @endforelse
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
                                    @if ($product->image)
                                        @if(str_starts_with($product->image, 'http'))
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                        @else
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                        @endif
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-medkit text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold mb-3">
                                    {{ $product->category->name ?? 'Produk' }}
                                </span>

                                <!-- Product Name -->
                                <a href="{{ route('products.show', $product) }}" class="hover:text-blue-600 block mb-2">
                                    <h3 class="font-semibold text-lg line-clamp-2">{{ $product->name }}</h3>
                                </a>

                                <!-- Price -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-blue-600 font-bold text-xl">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @if ($product->stock > 0)
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
                                        @if ($product->stock > 0)
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

    <!-- Become Vendor Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Information -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">
                        <i class="fas fa-store mr-3"></i>
                        Ingin Jadi Vendor?
                    </h2>
                    <p class="text-lg mb-6 text-purple-100">
                        Bergabunglah dengan ribuan vendor sukses di platform kami dan jangkau jutaan pelanggan di seluruh Indonesia!
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg mt-1">
                                <i class="fas fa-check text-green-300"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">Gratis Pendaftaran</h3>
                                <p class="text-purple-100">Tanpa biaya setup, mulai jualan hari ini juga</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg mt-1">
                                <i class="fas fa-chart-line text-green-300"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">Peluang Besar</h3>
                                <p class="text-purple-100">Akses ke ribuan customer potensial</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg mt-1">
                                <i class="fas fa-headset text-green-300"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg">Dukungan Penuh</h3>
                                <p class="text-purple-100">Tim support siap membantu 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: CTA -->
                <div class="bg-white rounded-2xl p-8 text-gray-800 shadow-2xl">
                    <h3 class="text-2xl font-bold mb-4 text-center">Daftar Sekarang</h3>
                    
                    @auth
                        @php
                            $shopRequest = Auth::user()->shopRequest;
                        @endphp
                        
                        @if($shopRequest)
                            <!-- Already have shop request -->
                            <div class="text-center py-4">
                                @if($shopRequest->status === 'pending')
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                        <i class="fas fa-clock text-yellow-600 text-3xl mb-2"></i>
                                        <h4 class="font-semibold text-yellow-800 mb-2">Menunggu Persetujuan</h4>
                                        <p class="text-sm text-yellow-700">
                                            Pengajuan Anda sedang dalam proses review oleh admin.
                                        </p>
                                    </div>
                                @elseif($shopRequest->status === 'approved')
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <i class="fas fa-check-circle text-green-600 text-3xl mb-2"></i>
                                        <h4 class="font-semibold text-green-800 mb-2">Sudah Disetujui</h4>
                                        <p class="text-sm text-green-700 mb-3">
                                            Anda sudah terdaftar sebagai vendor!
                                        </p>
                                        <a href="{{ route('vendor.dashboard') }}" 
                                           class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                                            <i class="fas fa-tachometer-alt mr-2"></i>
                                            Dashboard Vendor
                                        </a>
                                    </div>
                                @elseif($shopRequest->status === 'rejected')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                        <i class="fas fa-times-circle text-red-600 text-3xl mb-2"></i>
                                        <h4 class="font-semibold text-red-800 mb-2">Ditolak</h4>
                                        <p class="text-sm text-red-700 mb-2">
                                            {{ $shopRequest->rejection_reason ?? 'Pengajuan Anda ditolak.' }}
                                        </p>
                                        <a href="{{ route('shop-request.edit') }}" 
                                           class="inline-block bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                            <i class="fas fa-edit mr-2"></i>
                                            Ajukan Ulang
                                        </a>
                                    </div>
                                @endif
                                
                                <a href="{{ route('shop-request.show') }}" 
                                   class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat Detail Pengajuan
                                </a>
                            </div>
                        @else
                            <!-- No shop request yet -->
                            <p class="text-gray-600 mb-6 text-center">
                                Lengkapi data toko Anda dan mulai berjualan hari ini!
                            </p>
                            
                            <a href="{{ route('shop-request.create') }}" 
                               class="block w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 px-6 rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition transform hover:scale-105 active:scale-95 shadow-lg text-center">
                                <i class="fas fa-rocket mr-2"></i>
                                Daftar Jadi Vendor
                            </a>
                            
                            <div class="mt-4 text-center text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Proses persetujuan 1-2 hari kerja
                            </div>
                        @endif
                    @else
                        <!-- Not logged in -->
                        <div class="text-center py-4">
                            <p class="text-gray-600 mb-6">
                                Silakan login terlebih dahulu untuk mendaftar sebagai vendor.
                            </p>
                            
                            <div class="space-y-3">
                                <a href="{{ route('vendor.login') }}" 
                                   class="block w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login untuk Daftar
                                </a>
                                
                                <div class="text-sm text-gray-500">
                                    Belum punya akun?
                                    <a href="{{ route('vendor.register') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                                        Daftar di sini
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
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
