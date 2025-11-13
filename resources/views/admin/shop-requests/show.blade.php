@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Detail Aplikasi Toko</h1>
                <a href="{{ route('admin.shop-requests.index') }}" class="text-indigo-600 hover:underline">Kembali</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Status Card -->
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $shopRequest->shop_name }}</h2>
                            <span
                                class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                            @if ($shopRequest->isPending()) bg-yellow-100 text-yellow-800
                            @elseif($shopRequest->isApproved())
                                bg-green-100 text-green-800
                            @else
                                bg-red-100 text-red-800 @endif
                        ">
                                {{ ucfirst($shopRequest->status) }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Nama Pemilik / Email</p>
                                <p class="text-gray-800">{{ $shopRequest->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $shopRequest->user->email }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Alamat Toko</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_address }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Nomor Telepon</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_phone }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Deskripsi Toko</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_description ?? '-' }}</p>
                            </div>

                            @if ($shopRequest->isRejected() && $shopRequest->rejection_reason)
                                <div class="bg-red-50 border border-red-200 rounded p-3">
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Alasan Penolakan</p>
                                    <p class="text-red-800 mt-1">{{ $shopRequest->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                        <div class="space-y-3">
                            <div class="flex gap-4">
                                <div class="text-indigo-600 font-semibold">📝</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Diajukan</p>
                                    <p class="text-sm text-gray-600">{{ $shopRequest->submitted_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            @if ($shopRequest->isApproved())
                                <div class="flex gap-4">
                                    <div class="text-green-600 font-semibold">✅</div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Disetujui</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $shopRequest->approved_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            @elseif($shopRequest->isRejected())
                                <div class="flex gap-4">
                                    <div class="text-red-600 font-semibold">❌</div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Ditolak</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $shopRequest->rejected_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Actions -->
                <div class="lg:col-span-1">
                    @if ($shopRequest->isPending())
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindakan Admin</h3>

                            <!-- Approve Button -->
                            <form action="{{ route('admin.shop-requests.approve', $shopRequest) }}" method="POST"
                                class="mb-4">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">
                                    ✅ Setujui
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <details class="mb-4" id="rejectDetails">
                                <summary
                                    class="cursor-pointer bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg text-center block">
                                    ❌ Tolak
                                </summary>
                                <form action="{{ route('admin.shop-requests.reject', $shopRequest) }}" method="POST"
                                    class="mt-4">
                                    @csrf
                                    <textarea name="rejection_reason" required rows="3" placeholder="Jelaskan alasan penolakan..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
                                        Kirim Penolakan
                                    </button>
                                </form>
                            </details>
                        </div>
                    @elseif($shopRequest->isRejected())
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindakan Admin</h3>
                            <form action="{{ route('admin.shop-requests.reopen', $shopRequest) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                                    🔄 Buka Kembali
                                </button>
                            </form>
                        </div>
                    @elseif($shopRequest->isApproved())
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">✅ Sudah Disetujui</h3>
                            <p class="text-sm text-green-700">Pemilik toko sekarang bisa login dan menjual produk.</p>
                        </div>
                    @endif

                    <!-- Vendor Info -->
                    <div class="bg-white rounded-lg shadow p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Vendor</h3>
                        <div class="space-y-2">
                            <p class="text-sm"><strong>Nama:</strong> {{ $shopRequest->user->name }}</p>
                            <p class="text-sm"><strong>Email:</strong> {{ $shopRequest->user->email }}</p>
                            <p class="text-sm"><strong>Role:</strong> {{ ucfirst($shopRequest->user->role) }}</p>
                            <p class="text-sm"><strong>Terdaftar:</strong>
                                {{ $shopRequest->user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
