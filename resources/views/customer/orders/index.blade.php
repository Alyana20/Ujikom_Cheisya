@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">My Orders</h1>
            <p class="text-gray-600 mt-2">View and manage all your orders</p>
        </div>

        @if ($orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Order ID</p>
                                <p class="text-lg font-semibold text-gray-800">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-lg font-semibold text-gray-800">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="mt-1">
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
                                </p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <div class="border-t pt-3 text-sm text-gray-600">
                            <p>{{ $order->items->count() }} item(s) |
                                {{ $order->payment_status === 'pending' ? 'Payment Pending' : 'Paid via ' . ucfirst($order->payment_method) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Orders Yet</h2>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping now!</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
@endsection
