@extends('layouts.vendor')
@section('title', 'Lihat Pesanan')
@section('content')
<div class="container mx-auto px-4 py-8">
<div class="mb-6">
<div class="flex justify-between items-center">
<div>
<h1 class="text-2xl font-bold">Lihat Pesanan</h1>
<p class="text-gray-600">Kelola pesanan dan proses pengiriman produk</p>
</div>
<a href="{{ route('vendor.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
</svg>
Kembali ke Dashboard
</a>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Total Pesanan</div>
<div class="text-2xl font-bold">{{ $stats['total'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Menunggu</div>
<div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Diproses</div>
<div class="text-2xl font-bold text-blue-600">{{ $stats['processing'] }}</div>
</div>
<div class="bg-white p-4 rounded shadow">
<div class="text-gray-600 text-sm">Dikirim</div>
<div class="text-2xl font-bold text-green-600">{{ $stats['shipped'] }}</div>
</div>
</div>
@if($orders->count() > 0)
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full">
<thead class="bg-gray-50">
<tr>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
@foreach($orders as $order)
<tr>
<td class="px-4 py-3">#{{ $order->id }}</td>
<td class="px-4 py-3">{{ $order->user->name }}</td>
<td class="px-4 py-3">{{ $order->created_at->format('d M Y H:i') }}</td>
<td class="px-4 py-3">
@php
$vendorTotal = $order->items->sum('subtotal');
@endphp
Rp {{ number_format($vendorTotal, 0, ',', '.') }}
</td>
                <td class="px-4 py-3">
@if($order->status === 'pending')
<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">Menunggu</span>
@elseif($order->status === 'paid')
<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Dibayar</span>
@elseif($order->status === 'processing')
<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Diproses</span>
@elseif($order->status === 'shipped')
<span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-800">Sedang Dikirim</span>
@elseif($order->status === 'delivered')
<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Sudah Terkirim</span>
@elseif($order->status === 'cancelled')
<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Dibatalkan</span>
@else
<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
@endif
</td>
<td class="px-4 py-3">
<a href="{{ route('vendor.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="mt-4">
{{ $orders->links() }}
</div>
@else
<div class="bg-white rounded shadow p-8 text-center">
<svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
</svg>
<p class="mt-4 text-gray-500">Belum ada pesanan untuk produk Anda.</p>
</div>
@endif
</div>
@endsection