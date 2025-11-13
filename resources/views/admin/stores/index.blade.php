<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Toko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($stores->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">ID</th>
                                        <th class="px-4 py-2 text-left">Nama Toko</th>
                                        <th class="px-4 py-2 text-left">Pemilik</th>
                                        <th class="px-4 py-2 text-left">Alamat</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $store->id }}</td>
                                            <td class="px-4 py-2">{{ $store->name }}</td>
                                            <td class="px-4 py-2">{{ $store->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2">{{ $store->address }}</td>
                                            <td class="px-4 py-2">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm font-medium
                                                    @if ($store->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($store->status === 'approved') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800 @endif
                                                ">
                                                    {{ ucfirst($store->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 flex gap-2">
                                                @if ($store->status === 'pending')
                                                    <form method="POST"
                                                        action="{{ route('admin.stores.approve', $store) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">Setujui</button>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('admin.stores.reject', $store) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">Tolak</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $stores->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada toko.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
