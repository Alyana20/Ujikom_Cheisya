@extends('layouts.marketplace')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('products.index') }}"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Produk</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2 p-8">
                    <div class="bg-gray-100 rounded-lg h-96 flex items-center justify-center overflow-hidden">
                        @if ($product->image)
                            @if(str_starts_with($product->image, 'http'))
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover rounded-lg hover:scale-105 transition-transform duration-300">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover rounded-lg hover:scale-105 transition-transform duration-300">
                            @endif
                        @else
                            <div class="text-center text-gray-400">
                                <i class="fas fa-medkit text-6xl mb-4"></i>
                                <p>Gambar tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-1/2 p-8">
                    <!-- Category Badge -->
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold mb-4">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>

                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                    <!-- Price & Stock -->
                    <div class="flex items-center mb-6">
                        <span class="text-3xl font-bold text-blue-600">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if ($product->stock > 0)
                            <span class="ml-4 bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Tersedia
                            </span>
                        @else
                            <span class="ml-4 bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-times-circle mr-1"></i>Stok Habis
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-1">Kategori</h4>
                            <p class="text-gray-600">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-1">Stok</h4>
                            <p class="text-gray-600">{{ $product->stock }} unit</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-1">Toko</h4>
                            <p class="text-gray-600">{{ $product->store->name ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-1">Status</h4>
                            <p class="text-gray-600">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        @auth
                            @if ($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center text-lg">
                                        <i class="fas fa-cart-plus mr-3"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled
                                    class="flex-1 bg-gray-400 text-white py-4 px-6 rounded-lg font-semibold cursor-not-allowed text-lg">
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="flex-1 bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 text-center block text-lg">
                                <i class="fas fa-sign-in-alt mr-3"></i>
                                Login untuk Membeli
                            </a>
                        @endauth

                        <button
                            class="bg-gray-200 text-gray-700 py-4 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-200 text-lg">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <!-- Safety Info -->
                    @if (in_array($product->kategori, ['Obat', 'Suplemen']))
                        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-yellow-800 text-lg">Informasi Penting</h4>
                                    <p class="text-yellow-700 text-base mt-2">
                                        Konsultasikan dengan dokter sebelum menggunakan produk ini.
                                        Baca aturan pakai dan kontraindikasi dengan seksama.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <section class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Produk Serupa</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('products.show', $relatedProduct) }}">
                                <div class="h-48 bg-gray-200 overflow-hidden">
                                    @if ($relatedProduct->image)
                                        @if(str_starts_with($relatedProduct->image, 'http'))
                                            <img src="{{ $relatedProduct->image }}" alt="{{ $relatedProduct->name }}"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @endif
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-medkit text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $relatedProduct) }}" class="hover:text-blue-600 block">
                                    <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                                </a>
                                <p class="text-blue-600 font-bold text-lg mb-3">Rp
                                    {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                <a href="{{ route('products.show', $relatedProduct) }}"
                                    class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
