@extends('layouts.vendor')
@section('title', 'Kelola Produk')
@section('content')
<div class="container mx-auto px-4 py-8">
<div class="flex justify-between items-center mb-6">
<div>
<h1 class="text-2xl font-bold">Kelola Produk</h1>
</div>
<div class="flex gap-2">
<a href="{{ route('vendor.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
</svg>
Kembali
</a>
<a href="{{ route('vendor.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Produk</a>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Total Produk</div>
<div class="text-2xl font-bold">{{ $stats['total'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Produk Aktif</div>
<div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Stok Menipis</div>
<div class="text-2xl font-bold text-yellow-600">{{ $stats['low_stock'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Stok Habis</div>
<div class="text-2xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
</div>
</div>
@if($products->count() > 0)
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full">
<thead class="bg-gray-50">
<tr>
<th class="px-4 py-3 text-left">Gambar</th>
<th class="px-4 py-3 text-left">Nama</th>
<th class="px-4 py-3 text-left">Kategori</th>
<th class="px-4 py-3 text-left">Harga</th>
<th class="px-4 py-3 text-left">Stok</th>
<th class="px-4 py-3 text-left">Status</th>
<th class="px-4 py-3 text-left">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
@foreach($products as $product)
<tr>
<td class="px-4 py-3">
@if($product->image)
@if(str_starts_with($product->image, 'http'))
<img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
@else
<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
@endif
@else
<div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
<span class="text-gray-400 text-xs">No Image</span>
</div>
@endif
</td>
<td class="px-4 py-3">{{ $product->name }}</td>
<td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
<td class="px-4 py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
<td class="px-4 py-3">
<span class="@if($product->stock == 0) text-red-600 @elseif($product->stock < 10) text-yellow-600 @endif">
{{ $product->stock }}
</span>
</td>
<td class="px-4 py-3">
<form action="{{ route('vendor.products.toggle-status', $product->id) }}" method="POST">
@csrf
@method('PATCH')
<button type="submit" class="px-2 py-1 text-xs rounded {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
{{ ucfirst($product->status) }}
</button>
</form>
</td>
<td class="px-4 py-3">
<div class="flex space-x-2">
<a href="{{ route('vendor.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
<form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
@csrf
@method('DELETE')
<button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
</form>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="mt-4">
{{ $products->links() }}
</div>
@else
<div class="bg-white rounded shadow p-8 text-center">
<p class="text-gray-500 mb-4">Belum ada produk. Tambahkan produk pertama Anda!</p>
<a href="{{ route('vendor.products.create') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
Tambah Produk
</a>
</div>
@endif
</div>
@endsection