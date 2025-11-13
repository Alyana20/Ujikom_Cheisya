@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-gray-600 mt-2">Manage your orders, profile, and shop applications from here.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg">
                <p class="text-sm opacity-90">Total Orders</p>
                <p class="text-3xl font-bold">{{ Auth::user()->orders()->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg">
                <p class="text-sm opacity-90">Delivered Orders</p>
                <p class="text-3xl font-bold">{{ Auth::user()->orders()->where('status', 'delivered')->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg">
                <p class="text-sm opacity-90">Pending Orders</p>
                <p class="text-3xl font-bold">{{ Auth::user()->orders()->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-lg p-6 shadow-lg">
                <p class="text-sm opacity-90">Total Spent</p>
                <p class="text-3xl font-bold">Rp
                    {{ number_format(Auth::user()->orders()->sum('total_amount'), 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Recent Orders -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Recent Orders</h2>
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline font-medium">View All
                            →</a>
                    </div>

                    @php
                        $recentOrders = Auth::user()->orders()->with('items.product')->latest()->take(5)->get();
                    @endphp

                    @if ($recentOrders->count() > 0)
                        <div class="space-y-3">
                            @foreach ($recentOrders as $order)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="font-bold text-blue-600 hover:underline">
                                                Order #{{ $order->id }}
                                            </a>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $order->items->count() }} item(s) ·
                                                {{ $order->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-800">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            <p class="text-sm mt-1">
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
                                                @else
                                                    <span
                                                        class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs rounded font-medium">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                            <p class="text-gray-600 mb-4">No orders yet. Start shopping now!</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Browse Products
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4 cursor-pointer hover:shadow-md transition">
                        <a href="{{ route('products.index') }}" class="block text-center">
                            <p class="text-2xl mb-2">🛍️</p>
                            <p class="font-bold text-gray-800">Continue Shopping</p>
                            <p class="text-sm text-gray-600 mt-1">Browse our products</p>
                        </a>
                    </div>
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4 cursor-pointer hover:shadow-md transition">
                        <a href="{{ route('orders.index') }}" class="block text-center">
                            <p class="text-2xl mb-2">📦</p>
                            <p class="font-bold text-gray-800">My Orders</p>
                            <p class="text-sm text-gray-600 mt-1">View all orders</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Profile Card -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Profile</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Role</p>
                            <p class="font-medium text-gray-800">
                                @if (Auth::user()->isAdmin())
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded font-medium">Administrator</span>
                                @elseif(Auth::user()->isVendor())
                                    <span
                                        class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded font-medium">Vendor</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-medium">Customer</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="block w-full mt-4 px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition font-medium">
                        Edit Profile
                    </a>
                </div>

                <!-- Vendor Application -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Become a Vendor</h3>

                    @php
                        $shopRequest = Auth::user()->shopRequest;
                    @endphp

                    @if ($shopRequest)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Status:</p>
                            @if ($shopRequest->status === 'pending')
                                <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                                    <p class="font-medium text-yellow-900">⏳ Application Pending</p>
                                    <p class="text-sm text-yellow-700 mt-1">Admin is reviewing your application</p>
                                </div>
                            @elseif($shopRequest->status === 'approved')
                                <div class="bg-green-50 border border-green-200 rounded p-3">
                                    <p class="font-medium text-green-900">✓ Application Approved</p>
                                    <p class="text-sm text-green-700 mt-1">You are now a vendor!</p>
                                </div>
                            @elseif($shopRequest->status === 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded p-3">
                                    <p class="font-medium text-red-900">✗ Application Rejected</p>
                                    @if ($shopRequest->rejection_reason)
                                        <p class="text-sm text-red-700 mt-1">{{ $shopRequest->rejection_reason }}</p>
                                    @endif
                                    <a href="{{ route('shop-request.edit') }}"
                                        class="text-red-600 hover:underline text-sm mt-2 inline-block">Reapply</a>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('shop-request.show') }}"
                            class="block w-full px-4 py-2 bg-purple-600 text-white text-center rounded-lg hover:bg-purple-700 transition font-medium">
                            View Application
                        </a>
                    @else
                        <p class="text-sm text-gray-600 mb-4">Want to sell on our platform? Apply to become a vendor today!
                        </p>
                        <a href="{{ route('shop-request.create') }}"
                            class="block w-full px-4 py-2 bg-purple-600 text-white text-center rounded-lg hover:bg-purple-700 transition font-medium">
                            Apply Now
                        </a>
                    @endif
                </div>

                <!-- Support -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Need Help?</h3>
                    <p class="text-sm text-gray-600 mb-4">Check our FAQ or contact customer support for assistance.</p>
                    <a href="#"
                        class="block w-full px-4 py-2 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700 transition font-medium">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
