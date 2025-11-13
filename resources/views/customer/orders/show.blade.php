@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">&larr; Back to Orders</a>
            <h1 class="text-3xl font-bold text-gray-800 mt-4">Order #{{ $order->id }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Order Status Timeline -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Status</h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-600 rounded-full mr-4"></div>
                            <div>
                                <p class="font-medium text-gray-800">Order Placed</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-4 h-4 {{ $order->isPaid() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full mr-4">
                            </div>
                            <div>
                                <p class="font-medium {{ $order->isPaid() ? 'text-gray-800' : 'text-gray-400' }}">Payment
                                    Confirmed</p>
                                @if ($order->paid_at)
                                    <p class="text-sm text-gray-600">{{ $order->paid_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Waiting for confirmation</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div
                                class="w-4 h-4 {{ $order->isShipped() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full mr-4">
                            </div>
                            <div>
                                <p class="font-medium {{ $order->isShipped() ? 'text-gray-800' : 'text-gray-400' }}">Shipped
                                </p>
                                @if ($order->shipped_at)
                                    <p class="text-sm text-gray-600">{{ $order->shipped_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">Awaiting shipment</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div
                                class="w-4 h-4 {{ $order->isDelivered() ? 'bg-green-600' : 'bg-gray-300' }} rounded-full mr-4">
                            </div>
                            <div>
                                <p class="font-medium {{ $order->isDelivered() ? 'text-gray-800' : 'text-gray-400' }}">
                                    Delivered</p>
                                @if ($order->delivered_at)
                                    <p class="text-sm text-gray-600">{{ $order->delivered_at->format('d M Y, H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-500">On the way</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                <div class="flex gap-4">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <a href="{{ $item->product ? route('products.show', $item->product->id) : '#' }}"
                                            class="text-lg font-medium text-gray-800 hover:text-blue-600">
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
                                                        ->where('order_item_id', $item->id)
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
                                                            <input type="hidden" name="order_item_id"
                                                                value="{{ $item->id }}">

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
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-800">Rp
                                {{ number_format($order->items->sum(fn($i) => $i->subtotal), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium text-gray-800">Rp
                                {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-3">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-lg text-gray-800">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Payment</h2>

                    <div class="space-y-2 text-sm">
                        <p>
                            <span class="text-gray-600">Method:</span>
                            <span class="font-medium text-gray-800">{{ ucfirst($order->payment_method ?? 'cash') }}</span>
                        </p>
                        <p>
                            <span class="text-gray-600">Status:</span>
                            @if ($order->payment_status === 'pending')
                                <span
                                    class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded font-medium">Pending</span>
                            @elseif($order->payment_status === 'paid')
                                <span
                                    class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded font-medium">Paid</span>
                            @else
                                <span
                                    class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs rounded font-medium">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Delivery Address</h2>

                    <div class="text-sm space-y-2">
                        <p class="font-medium text-gray-800">{{ $order->recipient_name ?? auth()->user()->name }}</p>
                        <p class="text-gray-600">{{ $order->recipient_phone ?? auth()->user()->phone }}</p>
                        <p class="text-gray-600">{{ $order->delivery_address ?? 'Address not provided' }}</p>
                        <p class="text-gray-600">{{ $order->delivery_city ?? '' }}</p>
                    </div>
                </div>

                <!-- Actions -->
                @if ($order->canCancel())
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Cancel Order
                        </button>
                    </form>
                @elseif($order->isCancelled())
                    <div class="w-full px-4 py-3 bg-red-100 text-red-800 rounded-lg text-center font-medium">
                        Order Cancelled
                    </div>
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
