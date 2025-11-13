@extends('layouts.marketplace')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-credit-card mr-3 text-blue-600"></i>
            Pembayaran
        </h1>
        <p class="text-gray-600">Pesanan #{{ $mainOrder->id }} - Total: Rp {{ number_format($mainOrder->total_amount, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-6">
            <div class="inline-block p-4 bg-blue-50 rounded-full mb-4">
                <i class="fas fa-lock text-blue-600 text-4xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Pembayaran Aman dengan Midtrans</h2>
            <p class="text-gray-600">Pilih metode pembayaran Anda</p>
        </div>

        <!-- Midtrans Snap Payment Button -->
        <div id="snap-container"></div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 mb-4">
                <i class="fas fa-shield-alt mr-2"></i>
                Pembayaran dilindungi dengan enkripsi SSL
            </p>
            <a href="{{ route('orders.show', $mainOrder->id) }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Detail Pesanan
            </a>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '/payment/success?order_id={{ $mainOrder->id }}&transaction_id=' + result.transaction_id;
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '/payment/pending?order_id={{ $mainOrder->id }}';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Pembayaran gagal. Silakan coba lagi.');
                window.location.href = '{{ route('orders.show', $mainOrder->id) }}';
            },
            onClose: function() {
                console.log('Payment popup closed');
                alert('Anda menutup halaman pembayaran. Silakan lanjutkan pembayaran dari halaman pesanan.');
                window.location.href = '{{ route('orders.show', $mainOrder->id) }}';
            }
        });
    });
</script>
@endsection
