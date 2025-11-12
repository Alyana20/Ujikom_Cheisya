<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🏪 Kelola Toko
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                    {{ $store ? 'Edit Toko' : 'Buat Toko Baru' }}
                </h3>

                <form method="POST" action="{{ route('vendor.store.store') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Nama Toko</label>
                        <input type="text" name="name"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                            value="{{ old('name', $store->name ?? '') }}" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                            rows="4">{{ old('description', $store->description ?? '') }}</textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl shadow transition">
                        💾 Simpan
                    </button>

                    <a href="{{ route('vendor.dashboard') }}"
                        class="ml-4 text-gray-600 dark:text-gray-300 hover:underline">
                        ← Kembali ke Dashboard
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
