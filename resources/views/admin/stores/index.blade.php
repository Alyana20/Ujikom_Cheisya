@extends('layouts.admin')

@section('title', 'Kelola Toko')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('admin.stores.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Toko</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama toko, pemilik, email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.stores.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold">{{ $stores->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-2xl font-bold">{{ $stores->where('status', 'approved')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Inactive</p>
                    <p class="text-2xl font-bold">{{ $stores->where('status', 'inactive')->count() }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-ban text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rejected</p>
                    <p class="text-2xl font-bold">{{ $stores->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($stores as $store)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-store text-white"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($store->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $store->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $store->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900"><i class="fas fa-phone text-gray-400 mr-1"></i>{{ $store->phone }}</div>
                            <div class="text-sm text-gray-500 mt-1"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>{{ Str::limit($store->address, 30) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($store->status === 'pending')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i> Pending</span>
                            @elseif($store->status === 'approved')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i> Approved</span>
                            @elseif($store->status === 'inactive')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800"><i class="fas fa-ban mr-1"></i> Inactive</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i> Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $store->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($store->status === 'pending')
                                <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('Setujui toko ini?')" class="bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 text-sm">
                                        <i class="fas fa-check mr-1"></i>Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('Tolak toko ini?')" class="bg-red-600 text-white px-3 py-1.5 rounded hover:bg-red-700 text-sm ml-2">
                                        <i class="fas fa-times mr-1"></i>Reject
                                    </button>
                                </form>
                            @elseif($store->status === 'approved')
                                <form action="{{ route('admin.stores.toggle-active', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('Nonaktifkan toko ini?')" class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                                        <i class="fas fa-ban mr-1"></i>Nonaktifkan
                                    </button>
                                </form>
                            @elseif($store->status === 'inactive')
                                <form action="{{ route('admin.stores.toggle-active', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" onclick="return confirm('Aktifkan kembali toko ini?')" class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 text-sm">
                                        <i class="fas fa-check mr-1"></i>Aktifkan
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-500">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-store text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg">Tidak ada toko ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($stores->hasPages())
        <div class="mt-4">
            {{ $stores->links() }}
        </div>
    @endif
@endsection
