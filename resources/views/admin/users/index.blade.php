@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kelola User</h1>
                <p class="text-gray-600">Kelola semua pengguna sistem OSS Healthcare</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div
                class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->total() }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-500 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        12%
                    </span>
                    <span class="text-gray-500 ml-2">dari bulan lalu</span>
                </div>
            </div>

            <!-- Admin Users -->
            <div
                class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Administrator</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg">
                        <i class="fas fa-crown text-red-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <span>{{ number_format(($users->where('role', 'admin')->count() / $users->total()) * 100, 1) }}% dari
                        total</span>
                </div>
            </div>

            <!-- Vendor Users -->
            <div
                class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Vendor</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'vendor')->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-store text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <span>{{ number_format(($users->where('role', 'vendor')->count() / $users->total()) * 100, 1) }}% dari
                        total</span>
                </div>
            </div>

            <!-- Customer Users -->
            <div
                class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Customer</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'customer')->count() }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <span>{{ number_format(($users->where('role', 'customer')->count() / $users->total()) * 100, 1) }}% dari
                        total</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" placeholder="Cari user berdasarkan nama, email, atau telepon..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3">
                <select
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Role</option>
                    <option value="admin">Administrator</option>
                    <option value="vendor">Vendor</option>
                    <option value="customer">Customer</option>
                </select>
                <button
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Pengguna</h2>
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>User</span>
                                <i class="fas fa-sort ml-1 text-gray-400 cursor-pointer"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Role</span>
                                <i class="fas fa-sort ml-1 text-gray-400 cursor-pointer"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <span>Bergabung</span>
                                <i class="fas fa-sort ml-1 text-gray-400 cursor-pointer"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- User Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-primary-500 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-envelope mr-1 text-xs"></i>
                                            {{ $user->email }}
                                        </div>
                                        @if ($user->phone)
                                            <div class="text-sm text-gray-500 flex items-center mt-1">
                                                <i class="fas fa-phone mr-1 text-xs"></i>
                                                {{ $user->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $user->role === 'admin'
                                        ? 'bg-red-100 text-red-800 border border-red-200'
                                        : ($user->role === 'vendor'
                                            ? 'bg-green-100 text-green-800 border border-green-200'
                                            : 'bg-blue-100 text-blue-800 border border-blue-200') }}">
                                    <i
                                        class="fas {{ $user->role === 'admin' ? 'fa-crown' : ($user->role === 'vendor' ? 'fa-store' : 'fa-user') }} mr-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <!-- Store Info -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($user->store && $user->store->status === 'approved')
                                    <div class="flex items-center">
                                        <i class="fas fa-store text-green-500 mr-2"></i>
                                        <div>
                                            <span class="text-gray-900 font-medium">{{ $user->store->name }}</span>
                                            <div class="text-xs text-green-600 flex items-center">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Disetujui
                                            </div>
                                        </div>
                                    </div>
                                @elseif($user->store && $user->store->status === 'pending')
                                    <div class="flex items-center">
                                        <i class="fas fa-store text-yellow-500 mr-2"></i>
                                        <div>
                                            <span class="text-gray-900 font-medium">{{ $user->store->name }}</span>
                                            <div class="text-xs text-yellow-600 flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                Menunggu
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada toko</span>
                                @endif
                            </td>

                            <!-- Join Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    <div>
                                        <div>{{ $user->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Aktif
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg transition flex items-center group">
                                        <i class="fas fa-eye mr-1 group-hover:scale-110 transition-transform"></i>
                                        <span class="hidden md:inline">Detail</span>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-2 rounded-lg transition flex items-center group">
                                        <i class="fas fa-edit mr-1 group-hover:scale-110 transition-transform"></i>
                                        <span class="hidden md:inline">Edit</span>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition flex items-center group"
                                                onclick="return confirm('Yakin hapus user {{ $user->name }}?')">
                                                <i
                                                    class="fas fa-trash mr-1 group-hover:scale-110 transition-transform"></i>
                                                <span class="hidden md:inline">Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 bg-gray-50 px-3 py-2 rounded-lg flex items-center">
                                            <i class="fas fa-lock mr-1"></i>
                                            <span class="hidden md:inline">Anda</span>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-500 mb-2">Belum ada user terdaftar</p>
                                    <p class="text-gray-400 text-sm">User yang mendaftar akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari
                        {{ $users->total() }} user
                    </div>
                    <div class="flex space-x-2">
                        @if ($users->onFirstPage())
                            <span
                                class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed flex items-center">
                                <i class="fas fa-chevron-left mr-2"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition flex items-center">
                                <i class="fas fa-chevron-left mr-2"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition flex items-center">
                                Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        @else
                            <span
                                class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed flex items-center">
                                Selanjutnya <i class="fas fa-chevron-right ml-2"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
