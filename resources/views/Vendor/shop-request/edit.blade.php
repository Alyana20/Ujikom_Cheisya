@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Aplikasi Toko</h1>

            <div class="bg-white rounded-lg shadow p-6 md:p-8 max-w-2xl">
                <form action="{{ route('shop-request.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Shop Name -->
                    <div>
                        <label for="shop_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="shop_name" name="shop_name" required
                            value="{{ old('shop_name', $shopRequest->shop_name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('shop_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Description -->
                    <div>
                        <label for="shop_description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Toko
                        </label>
                        <textarea id="shop_description" name="shop_description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('shop_description', $shopRequest->shop_description) }}</textarea>
                        @error('shop_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Address -->
                    <div>
                        <label for="shop_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Toko <span class="text-red-500">*</span>
                        </label>
                        <textarea id="shop_address" name="shop_address" rows="2" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('shop_address', $shopRequest->shop_address) }}</textarea>
                        @error('shop_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Phone -->
                    <div>
                        <label for="shop_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="shop_phone" name="shop_phone" required
                            value="{{ old('shop_phone', $shopRequest->shop_phone) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('shop_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('shop-request.show') }}"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
