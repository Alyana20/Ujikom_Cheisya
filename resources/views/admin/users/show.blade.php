<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - OSS Healthcare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">OSS Healthcare - Admin Panel</h1>
                <p class="text-blue-200">Halo, {{ Auth::user()->name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-blue-500 px-3 py-1 rounded-full">Admin</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded transition">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">User Details</h1>
                <p class="text-gray-600">Detail informasi user</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow p-6 col-span-2">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>Informasi Dasar
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Role</label>
                        <span
                            class="mt-1 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            {{ $user->role === 'admin'
                                ? 'bg-red-100 text-red-800 border border-red-200'
                                : ($user->role === 'vendor'
                                    ? 'bg-green-100 text-green-800 border border-green-200'
                                    : 'bg-blue-100 text-blue-800 border border-blue-200') }}">
                            <i
                                class="fas
                                {{ $user->role === 'admin' ? 'fa-crown' : ($user->role === 'vendor' ? 'fa-store' : 'fa-user') }}
                                mr-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Bergabung Pada</label>
                        <p class="mt-1 text-gray-900">
                            <i class="fas fa-calendar mr-1 text-gray-400"></i>
                            {{ $user->created_at->format('d F Y H:i') }}
                        </p>
                    </div>

                    @if ($user->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Telepon</label>
                            <p class="mt-1 text-gray-900">
                                <i class="fas fa-phone mr-1 text-gray-400"></i>
                                {{ $user->phone }}
                            </p>
                        </div>
                    @endif

                    @if ($user->address)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600">Alamat</label>
                            <p class="mt-1 text-gray-900">
                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                {{ $user->address }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile & Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-id-card mr-2 text-green-500"></i>Profile
                </h2>

                <div class="flex flex-col items-center mb-6">
                    <div class="h-24 w-24 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                        <span class="text-white font-bold text-2xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i> Edit User
                    </a>

                    @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition flex items-center justify-center"
                                onclick="return confirm('Yakin hapus user {{ $user->name }}?')">
                                <i class="fas fa-trash mr-2"></i> Delete User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Store Information (if vendor) -->
        @if ($user->store)
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-store mr-2 text-purple-500"></i>Informasi Toko
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Toko</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->store->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">Status Toko</label>
                        <span
                            class="mt-1 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        {{ $user->store->status === 'approved'
                            ? 'bg-green-100 text-green-800 border border-green-200'
                            : ($user->store->status === 'pending'
                                ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                : 'bg-red-100 text-red-800 border border-red-200') }}">
                            <i
                                class="fas
                            {{ $user->store->status === 'approved'
                                ? 'fa-check'
                                : ($user->store->status === 'pending'
                                    ? 'fa-clock'
                                    : 'fa-times') }}
                            mr-1"></i>
                            {{ ucfirst($user->store->status) }}
                        </span>
                    </div>

                    @if ($user->store->description)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600">Deskripsi Toko</label>
                            <p class="mt-1 text-gray-900">{{ $user->store->description }}</p>
                        </div>
                    @endif

                    @if ($user->store->address)
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Alamat Toko</label>
                            <p class="mt-1 text-gray-900">
                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                {{ $user->store->address }}
                            </p>
                        </div>
                    @endif

                    @if ($user->store->city)
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Kota</label>
                            <p class="mt-1 text-gray-900">{{ $user->store->city }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Activity Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-chart-bar mr-2 text-orange-500"></i>Statistik
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <i class="fas fa-store text-2xl text-blue-500 mb-2"></i>
                    <p class="text-sm text-gray-600">Total Toko</p>
                    <p class="text-xl font-bold text-gray-800">{{ $user->store ? 1 : 0 }}</p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <i class="fas fa-box text-2xl text-green-500 mb-2"></i>
                    <p class="text-sm text-gray-600">Total Produk</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $user->store ? $user->store->products->count() : 0 }}</p>
                </div>

                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <i class="fas fa-shopping-cart text-2xl text-purple-500 mb-2"></i>
                    <p class="text-sm text-gray-600">Total Orders</p>
                    <p class="text-xl font-bold text-gray-800">0</p>
                </div>

                <div class="text-center p-4 bg-orange-50 rounded-lg">
                    <i class="fas fa-calendar text-2xl text-orange-500 mb-2"></i>
                    <p class="text-sm text-gray-600">Member Since</p>
                    <p class="text-lg font-bold text-gray-800">{{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded shadow-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif
</body>

</html>
