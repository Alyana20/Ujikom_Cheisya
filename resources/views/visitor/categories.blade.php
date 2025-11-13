@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-12">🛒 Kategori Produk</h1>

            <!-- Category Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($categories as $category)
                    <a href="{{ route('products.byCategory', $category->slug) }}"
                        class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 text-center">
                        <div class="text-5xl mb-4">{{ $category->icon ?? '📦' }}</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                        <p class="text-indigo-600 font-semibold">
                            {{ $category->products_count }} Produk
                        </p>
                    </a>
                @endforeach
            </div>

            <!-- Semua Produk di bawah kategori -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Semua Produk</h2>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    Lihat Semua Produk →
                </a>
            </div>
        </div>
    </div>
@endsection
