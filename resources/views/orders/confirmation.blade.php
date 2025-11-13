<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Konfirmasi Pesanan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded">
                <h3 class="text-lg font-semibold mb-4">Pesanan #{{ $order->id }}</h3>
                <p class="mb-4">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                <h4 class="font-semibold">Items</h4>
                <ul class="mb-4">
                    @foreach ($order->items as $item)
                        <li>{{ $item->quantity }} x {{ $item->product->nama }} — Rp
                            {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                    @endforeach
                </ul>

                <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
                <p class="text-sm text-gray-600">Alamat: {{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
