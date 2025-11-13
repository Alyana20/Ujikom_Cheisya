@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Status Aplikasi Toko</h1>
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Kembali ke Dashboard</a>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow p-6 md:p-8 mb-6">
                @if ($shopRequest->isPending())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">⏳</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-800">
                                    Aplikasi Anda sedang dalam proses review. Admin akan menghubungi Anda dalam waktu
                                    singkat.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($shopRequest->isApproved())
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">✅</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Selamat! Toko Anda telah disetujui. Anda sekarang bisa menjadi vendor dan menjual
                                    produk.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($shopRequest->isRejected())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">❌</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    Aplikasi toko Anda telah ditolak. Silakan perbaiki informasi dan ajukan kembali.
                                </p>
                                @if ($shopRequest->rejection_reason)
                                    <p class="text-sm text-red-700 mt-2 italic">
                                        <strong>Alasan:</strong> {{ $shopRequest->rejection_reason }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Informasi Toko</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Nama Toko</p>
                                <p class="text-gray-800 font-medium">{{ $shopRequest->shop_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Alamat</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_address }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Nomor Telepon</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Deskripsi</p>
                                <p class="text-gray-800">{{ $shopRequest->shop_description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-4">Timeline</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Diajukan Pada</p>
                                <p class="text-gray-800">{{ $shopRequest->submitted_at?->format('d M Y H:i') ?? '-' }}</p>
                            </div>
                            @if ($shopRequest->isApproved())
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Disetujui Pada</p>
                                    <p class="text-gray-800">{{ $shopRequest->approved_at->format('d M Y H:i') }}</p>
                                </div>
                            @elseif($shopRequest->isRejected())
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Ditolak Pada</p>
                                    <p class="text-gray-800">{{ $shopRequest->rejected_at->format('d M Y H:i') }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Status</p>
                                <p
                                    class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if ($shopRequest->isPending()) bg-yellow-100 text-yellow-800
                                @elseif($shopRequest->isApproved())
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800 @endif
                            ">
                                    {{ ucfirst($shopRequest->status) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex gap-4">
                    @if ($shopRequest->isPending() || $shopRequest->isRejected())
                        <a href="{{ route('shop-request.edit') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Edit Aplikasi
                        </a>
                    @endif

                    @if ($shopRequest->isApproved())
                        <a href="{{ route('vendor.dashboard') }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Ke Dashboard Vendor
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
