@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Ajukan Toko Baru</h1>

            @if ($existingRequest)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <p class="text-blue-800">
                        <strong>Anda sudah memiliki aplikasi toko dengan status:</strong>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if ($existingRequest->isPending()) bg-yellow-100 text-yellow-800
                        @elseif($existingRequest->isApproved())
                            bg-green-100 text-green-800
                        @else
                            bg-red-100 text-red-800 @endif
                    ">
                            {{ ucfirst($existingRequest->status) }}
                        </span>
                    </p>
                    @if ($existingRequest->isPending() || $existingRequest->isRejected())
                        <a href="{{ route('shop-request.show') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                            Lihat Status →
                        </a>
                    @endif
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6 md:p-8 max-w-2xl">
                <form action="{{ route('shop-request.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Shop Name -->
                    <div>
                        <label for="shop_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="shop_name" name="shop_name" required value="{{ old('shop_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Contoh: Toko Kesehatan Jaya">
                        @error('shop_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Description -->
                    <div>
                        <label for="shop_description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Toko
                        </label>
                        <textarea id="shop_description" name="shop_description" rows="4" value="{{ old('shop_description') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Jelaskan tentang toko Anda, produk apa saja yang dijual, keunggulan Anda..."></textarea>
                        @error('shop_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Address -->
                    <div>
                        <label for="shop_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Toko <span class="text-red-500">*</span>
                        </label>
                        <textarea id="shop_address" name="shop_address" rows="2" required value="{{ old('shop_address') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Jalan, nomor, kelurahan, kecamatan, kota, provinsi, kode pos"></textarea>
                        @error('shop_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Phone -->
                    <div>
                        <label for="shop_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="shop_phone" name="shop_phone" required value="{{ old('shop_phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="0812345678">
                        @error('shop_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg">
                            Kirim Aplikasi
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <h3 class="font-semibold text-yellow-900 mb-3">📋 Catatan Penting</h3>
                <ul class="text-yellow-800 text-sm space-y-2">
                    <li>✓ Admin akan mereview aplikasi Anda dalam 1-3 hari kerja.</li>
                    <li>✓ Pastikan informasi toko Anda akurat dan lengkap.</li>
                    <li>✓ Setelah disetujui, Anda bisa mulai menjual produk.</li>
                    <li>✓ Jika ditolak, Anda bisa mengajukan ulang setelah memperbaiki informasi.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
