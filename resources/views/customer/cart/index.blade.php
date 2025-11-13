@extends('layouts.marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            <i class="fas fa-shopping-cart mr-3 text-blue-600"></i>
            Keranjang Belanja
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Daftar Produk ({{ $cartItems->count() }} item)</h2>
                @foreach($cartItems as $item)
                    <div class="flex gap-4 border-b pb-4 mb-4">
                        <div class="w-20 h-20">
                            @if($item->product->image)
                                @if(str_starts_with($item->product->image, 'http'))
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                @else
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                @endif
                            @else
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->product->store->name }}</p>
                            <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PUT')
                                <div class="flex items-center gap-2">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 border rounded px-2 py-1 text-center">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Update</button>
                                </div>
                            </form>
                            <p class="text-sm font-bold mb-2">Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('Hapus produk?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Ringkasan</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Total Item:</span>
                            <span class="font-bold">{{ $cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between text-lg border-t pt-2">
                            <span class="font-bold">Total:</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-bold hover:bg-green-700 mb-2">
                        <i class="fas fa-credit-card mr-2"></i> Checkout
                    </a>
                    <a href="{{ route('products.index') }}" class="block w-full bg-gray-200 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-300">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-bold mb-2">Keranjang Kosong</h2>
            <p class="text-gray-600 mb-6">Belum ada produk di keranjang</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700">
                <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection