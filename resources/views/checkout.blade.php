<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Checkout</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded">
                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Alamat Pengiriman</label>
                        <textarea name="shipping_address" class="w-full border rounded p-2" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full border rounded p-2">
                            <option value="cod">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <div class="mt-6 text-right">
                        <button class="px-4 py-2 bg-green-600 text-white rounded">Bayar / Buat Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
