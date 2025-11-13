@extends('layouts.marketplace')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pesanan
            </a>
            <h1 class="text-3xl font-bold mt-4">
                <i class="fas fa-receipt mr-3 text-blue-600"></i>
                Detail Pesanan #{{ $order->id }}
            </h1>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Order Status Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fas fa-shipping-fast mr-3 text-blue-600"></i>
                        Status Pesanan
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Pesanan Dibuat</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-10 h-10 {{ $order->isPaid() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center mr-4">
                                <i class="fas {{ $order->isPaid() ? 'fa-check' : 'fa-clock' }} text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold {{ $order->isPaid() ? 'text-gray-800' : 'text-gray-400' }}">Pembayaran Dikonfirmasi</p>
                                @if ($order->paid_at)
                                    <p class="text-sm text-gray-600">{{ $order->paid_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Menunggu konfirmasi</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-10 h-10 {{ $order->isShipped() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center mr-4">
                                <i class="fas {{ $order->isShipped() ? 'fa-check' : 'fa-clock' }} text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold {{ $order->isShipped() ? 'text-gray-800' : 'text-gray-400' }}">Dikirim</p>
                                @if ($order->shipped_at)
                                    <p class="text-sm text-gray-600">{{ $order->shipped_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Menunggu pengiriman</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-10 h-10 {{ $order->isDelivered() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full flex items-center justify-center mr-4">
                                <i class="fas {{ $order->isDelivered() ? 'fa-check' : 'fa-clock' }} text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold {{ $order->isDelivered() ? 'text-gray-800' : 'text-gray-400' }}">Diterima</p>
                                @if ($order->delivered_at)
                                    <p class="text-sm text-gray-600">{{ $order->delivered_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Dalam perjalanan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-box mr-3 text-blue-600"></i>
                        Produk Pesanan
                    </h2>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <div class="flex gap-4">
                                    @if ($item->product && $item->product->image)
                                        @if(str_starts_with($item->product->image, 'http'))
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                        @else
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                        @endif
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <a href="{{ $item->product ? route('products.show', $item->product->id) : '#' }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                                            {{ $item->product->name ?? 'Product' }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Qty: <span class="font-medium">{{ $item->quantity }}</span>
                                            × Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-base font-semibold text-gray-800 mt-2">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>

                                        <!-- Review Section (only for delivered orders) -->
                                        @if ($order->isDelivered())
                                            <div class="mt-3">
                                                @php
                                                    $existingReview = $item->product
                                                        ->reviews()
                                                        ->where('user_id', auth()->id())
                                                        ->first();
                                                @endphp

                                                @if ($existingReview)
                                                    <div class="bg-blue-50 border border-blue-200 rounded p-3">
                                                        <p class="text-sm font-medium text-blue-900">✓ You reviewed this
                                                            product</p>
                                                        <div class="flex items-center mt-1">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <span
                                                                    class="text-yellow-500">{{ $i <= $existingReview->rating ? '★' : '☆' }}</span>
                                                            @endfor
                                                            <span
                                                                class="text-sm text-gray-700 ml-2">({{ $existingReview->rating }}/5)</span>
                                                        </div>
                                                        @if ($existingReview->comment)
                                                            <p class="text-sm text-gray-700 mt-2 italic">
                                                                {{ $existingReview->comment }}</p>
                                                        @endif
                                                        <form action="{{ route('reviews.destroy', $existingReview->id) }}"
                                                            method="POST" class="mt-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-sm text-red-600 hover:underline">Delete
                                                                Review</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <button class="text-sm text-blue-600 hover:underline font-medium"
                                                        onclick="toggleReviewForm('review-{{ $item->id }}')">
                                                        + Write a Review
                                                    </button>

                                                    <div id="review-{{ $item->id }}"
                                                        class="hidden mt-3 bg-gray-50 border border-gray-200 rounded p-4">
                                                        <form action="{{ route('reviews.store', $item->product->id) }}"
                                                            method="POST" class="space-y-3">
                                                            @csrf

                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                                <div class="flex gap-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <input type="radio" name="rating"
                                                                            value="{{ $i }}"
                                                                            id="rating-{{ $item->id }}-{{ $i }}"
                                                                            class="hidden" required>
                                                                        <label
                                                                            for="rating-{{ $item->id }}-{{ $i }}"
                                                                            class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-500 transition"
                                                                            onclick="updateStars('rating-{{ $item->id }}-{{ $i }}')">★</label>
                                                                    @endfor
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-2">Comment
                                                                    (Optional)
                                                                </label>
                                                                <textarea name="comment" placeholder="Share your experience..."
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                                    rows="3"></textarea>
                                                            </div>

                                                            <div class="flex gap-2">
                                                                <button type="submit"
                                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">Submit
                                                                    Review</button>
                                                                <button type="button"
                                                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
                                                                    onclick="toggleReviewForm('review-{{ $item->id }}')">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar: Summary & Actions -->
            <div class="lg:col-span-1">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-calculator mr-2 text-blue-600"></i>
                        Ringkasan Pesanan
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($order->items->sum(fn($i) => $i->subtotal), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-semibold text-green-600">{{ $order->shipping_cost ? 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') : 'Gratis' }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-3">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-xl text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                        Pembayaran
                    </h2>

                    <div class="space-y-2 text-sm">
                        <p>
                            <span class="text-gray-600">Metode:</span>
                            <span class="font-semibold text-gray-800">{{ strtoupper($order->payment_method ?? 'COD') }}</span>
                        </p>
                        <p>
                            <span class="text-gray-600">Status:</span>
                            @if ($order->payment_status === 'pending')
                                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-semibold">Menunggu</span>
                            @elseif($order->payment_status === 'paid')
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">Dibayar</span>
                            @else
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-semibold">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Alamat Pengiriman
                    </h2>

                    <div class="text-sm space-y-2">
                        <p class="font-semibold text-gray-800">{{ $order->recipient_name ?? auth()->user()->name }}</p>
                        <p class="text-gray-600"><i class="fas fa-phone mr-2"></i>{{ $order->recipient_phone ?? auth()->user()->phone }}</p>
                        <p class="text-gray-600"><i class="fas fa-home mr-2"></i>{{ $order->delivery_address ?? 'Alamat tidak tersedia' }}</p>
                        @if($order->delivery_city)
                            <p class="text-gray-600">{{ $order->delivery_city }}</p>
                        @endif
                        @if($order->notes)
                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-xs text-gray-500 mb-1"><i class="fas fa-sticky-note mr-1"></i>Catatan:</p>
                                <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @if ($order->canCancel())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-red-700 mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Anda dapat membatalkan pesanan ini selama statusnya masih Pending atau Dibayar.
                        </p>
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok produk akan dikembalikan.');">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-bold shadow-md">
                                <i class="fas fa-times-circle mr-2"></i>Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @elseif($order->isCancelled())
                    <div class="w-full px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-center font-semibold">
                        <i class="fas fa-ban mr-2"></i>Pesanan Dibatalkan
                    </div>
                @elseif($order->isDelivered())
                    <div class="w-full px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-center font-semibold mb-4">
                        <i class="fas fa-check-circle mr-2"></i>Pesanan Selesai
                    </div>
                    <a href="{{ route('orders.invoice', $order->id) }}" class="block w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-bold shadow-md text-center">
                        <i class="fas fa-download mr-2"></i>Download Invoice
                    </a>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleReviewForm(id) {
            const elem = document.getElementById(id);
            elem.classList.toggle('hidden');
        }

        function updateStars(id) {
            const input = document.getElementById(id);
            const rating = input.value;
            const baseId = id.replace(/-[1-5]$/, '');

            document.querySelectorAll(`label[for^="${baseId}"]`).forEach((label, idx) => {
                label.textContent = (idx + 1) <= rating ? '★' : '☆';
                label.style.color = (idx + 1) <= rating ? '#fbbf24' : '#d1d5db';
            });
        }
    </script>
@endsection
