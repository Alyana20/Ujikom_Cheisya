@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Review Aplikasi Toko ({{ $shopRequests->total() }})</h1>
                <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:underline">Kembali ke Admin</a>
            </div>

            <!-- Filter Status -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('admin.shop-requests.index') }}"
                        class="px-4 py-2 rounded-lg font-semibold {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach (['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $status => $label)
                        <a href="{{ route('admin.shop-requests.index', ['status' => $status]) }}"
                            class="px-4 py-2 rounded-lg font-semibold {{ request('status') === $status ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if ($shopRequests->count() > 0)
                <!-- Shop Requests Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Toko</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Pemilik</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Diajukan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($shopRequests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800">{{ $request->shop_name }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($request->shop_address, 40) }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800">{{ $request->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $request->shop_phone }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($request->isPending()) bg-yellow-100 text-yellow-800
                                        @elseif($request->isApproved())
                                            bg-green-100 text-green-800
                                        @else
                                            bg-red-100 text-red-800 @endif
                                    ">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $request->submitted_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('admin.shop-requests.show', $request) }}"
                                            class="text-indigo-600 hover:underline font-semibold">
                                            Lihat →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $shopRequests->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-gray-600 text-lg">Tidak ada aplikasi toko untuk ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
