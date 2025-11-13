<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Keranjang Belanja</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800">{{ session('error') }}</div>
            @endif

            @if (count($cart) > 0)
                <table class="w-full table-auto bg-white shadow-sm rounded">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Produk</th>
                            <th class="p-3 text-left">Harga</th>
                            <th class="p-3 text-left">Qty</th>
                            <th class="p-3 text-left">Subtotal</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($cart as $item)
                            @php $total += $item['subtotal']; @endphp
                            <tr class="border-b">
                                <td class="p-3">{{ $item['nama'] }}</td>
                                <td class="p-3">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('cart.update') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                            min="1" class="w-20 border rounded p-1">
                                        <button class="ml-2 px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                                    </form>
                                </td>
                                <td class="p-3">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('cart.remove') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <button class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 text-right">
                    <p class="text-lg font-semibold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                    <a href="{{ route('checkout.show') }}"
                        class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded">Checkout</a>
                </div>
            @else
                <div class="p-6 bg-white shadow-sm rounded">Keranjang kosong.</div>
            @endif
        </div>
    </div>
</x-app-layout>
