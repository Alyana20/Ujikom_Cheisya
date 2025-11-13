@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">&larr; Back to Orders</a>
            <h1 class="text-3xl font-bold text-gray-800 mt-4">Order #{{ $order->id }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Order Status & Actions -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Order Status</h2>
                        <div class="text-right">
                            @if ($order->isPending())
                                <span
                                    class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full font-medium">Pending</span>
                            @elseif($order->isPaid())
                                <span
                                    class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">Paid</span>
                            @elseif($order->isShipped())
                                <span
                                    class="inline-block px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full font-medium">Shipped</span>
                            @elseif($order->isDelivered())
                                <span
                                    class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Delivered</span>
                            @elseif($order->isCancelled())
                                <span
                                    class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">Cancelled</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="space-y-3 mb-6">
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
                                    <p class="text-sm text-gray-500">Awaiting confirmation</p>
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
                                    <p class="text-sm text-gray-500">Not shipped yet</p>
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
                                    <p class="text-sm text-gray-500">Not delivered yet</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    <div class="border-t pt-4">
                        <p class="text-sm font-medium text-gray-700 mb-3">Quick Actions</p>
                        <div class="flex flex-wrap gap-2">
                            @if (!$order->isShipped() && !$order->isDelivered() && !$order->isCancelled())
                                <form action="{{ route('orders.ship', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                                        Mark as Shipped
                                    </button>
                                </form>
                            @endif

                            @if ($order->isShipped() && !$order->isDelivered())
                                <form action="{{ route('orders.deliver', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                        Mark as Delivered
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Order Items ({{ $order->items->count() }} items)</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Product</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Qty</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Price</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-800">
                                                {{ $item->product->name ?? 'Product Deleted' }}</div>
                                            <div class="text-sm text-gray-600">SKU: {{ $item->product->sku ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right text-gray-800">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-right text-gray-800">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp
                                            {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Summary & Customer Info -->
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

                <!-- Customer Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Customer</h2>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium">Name</p>
                            <p class="text-gray-800 font-semibold">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium">Email</p>
                            <p class="text-gray-800">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium">Phone</p>
                            <p class="text-gray-800">{{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Delivery Address</h2>

                    <div class="space-y-2 text-sm text-gray-800">
                        <p class="font-medium">{{ $order->recipient_name ?? 'N/A' }}</p>
                        <p>{{ $order->recipient_phone ?? 'N/A' }}</p>
                        <p class="line-clamp-3">{{ $order->delivery_address ?? 'Address not provided' }}</p>
                        <p>{{ $order->delivery_city ?? '' }}</p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
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
            </div>
        </div>
    </div>
@endsection
