@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Order Management</h1>
            <p class="text-gray-600 mt-2">View and manage all customer orders</p>
        </div>

        <!-- Filters -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered
                        </option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Order ID</label>
                    <input type="text" name="search" placeholder="Enter order ID..." value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}"
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                    Clear
                </a>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-medium text-blue-600">Total Orders</p>
                <p class="text-3xl font-bold text-blue-800">{{ $orders->total() }}</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm font-medium text-yellow-600">Pending Payment</p>
                <p class="text-3xl font-bold text-yellow-800">
                    {{ \App\Models\Order::where('payment_status', 'pending')->count() }}</p>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <p class="text-sm font-medium text-purple-600">Processing</p>
                <p class="text-3xl font-bold text-purple-800">
                    {{ \App\Models\Order::where('status', 'processing')->count() }}</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm font-medium text-green-600">Delivered</p>
                <p class="text-3xl font-bold text-green-800">{{ \App\Models\Order::where('status', 'delivered')->count() }}
                </p>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Order ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Payment</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="hover:underline">#{{ $order->id }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <div class="font-medium">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-600">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
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
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($order->isPending())
                                    <span
                                        class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded font-medium">Pending</span>
                                @elseif($order->isPaid())
                                    <span
                                        class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-medium">Paid</span>
                                @elseif($order->isShipped())
                                    <span
                                        class="inline-block px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded font-medium">Shipped</span>
                                @elseif($order->isDelivered())
                                    <span
                                        class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded font-medium">Delivered</span>
                                @elseif($order->isCancelled())
                                    <span
                                        class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs rounded font-medium">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-600">
                                No orders found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($orders->count() > 0)
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
