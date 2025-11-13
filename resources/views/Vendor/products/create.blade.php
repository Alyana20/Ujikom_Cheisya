@extends('layouts.vendor')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-plus-circle mr-3 text-green-600"></i>
            Tambah Produk Baru
        </h1>
        <p class="mt-2 text-gray-600">
            Tambahkan produk baru untuk toko <span class="font-semibold text-green-600">{{ $store->name }}</span>
        </p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Terjadi kesalahan:
            </p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-info-circle mr-3"></i>
                    Informasi Produk
                </h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:border-green-500"
                        value="{{ old('name') }}" 
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="category_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:border-green-500"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="price"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:border-green-500"
                            value="{{ old('price') }}" 
                            required
                            min="0"
                            step="0.01">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="stock"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:border-green-500"
                            value="{{ old('stock') }}" 
                            required
                            min="0">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Deskripsi Produk
                    </label>
                    <textarea 
                        name="description" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:border-green-500"
                        rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Image -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Gambar Produk
                    </label>
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
                                    <span>Upload gambar</span>
                                    <input 
                                        id="image" 
                                        name="image" 
                                        type="file" 
                                        class="sr-only"
                                        accept="image/*"
                                        onchange="previewImage(event)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 2MB
                            </p>
                        </div>
                    </div>
                    <div id="imagePreview" class="mt-4 hidden">
                        <img src="" alt="Preview" class="max-w-xs rounded-lg shadow-lg mx-auto">
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 flex gap-3">
                <button 
                    type="submit"
                    class="bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Produk
                </button>

                <a 
                    href="{{ route('vendor.products.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
