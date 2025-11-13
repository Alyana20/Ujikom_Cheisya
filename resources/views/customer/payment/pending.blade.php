@extends('layouts.marketplace')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <div class="inline-block p-6 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-6xl"></i>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-4">Pembayaran Pending</h1>
        <p class="text-gray-600 mb-8">Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran.</p>

        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <p class="text-sm text-gray-500">Order ID</p>
                    <p class="font-bold text-gray-800">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                    <p class="font-bold text-yellow-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-bold text-yellow-600">
                        <i class="fas fa-hourglass-half mr-2"></i>Menunggu Pembayaran
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Silakan selesaikan pembayaran sesuai instruksi yang diberikan. Status akan diperbarui otomatis setelah pembayaran dikonfirmasi.
            </p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('orders.show', $order->id) }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                <i class="fas fa-receipt mr-2"></i>Lihat Detail Pesanan
            </a>
            <a href="{{ route('orders.index') }}" class="block w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-300 transition">
                <i class="fas fa-list mr-2"></i>Lihat Semua Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
