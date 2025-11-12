<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - OSS Healthcare</title>
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
                <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
                <p class="text-gray-600">Edit informasi user</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.show', $user) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition flex items-center">
                    <i class="fas fa-eye mr-2"></i> View User
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6 col-span-2">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-edit mr-2 text-green-500"></i>Edit User Information
                </h2>

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap
                                *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                            <select id="role" name="role"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="customer"
                                    {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="vendor" {{ old('role', $user->role) === 'vendor' ? 'selected' : '' }}>
                                    Vendor</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Update User
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Info Sidebar -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>User Information
                </h2>

                <div class="flex flex-col items-center mb-6">
                    <div class="h-20 w-20 bg-blue-500 rounded-full flex items-center justify-center mb-3">
                        <span class="text-white font-bold text-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">User ID:</span>
                        <span class="font-medium">{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Role Saat Ini:</span>
                        <span class="font-medium capitalize">{{ $user->role }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Bergabung:</span>
                        <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Terakhir Update:</span>
                        <span class="font-medium">{{ $user->updated_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Danger Zone -->
                @if ($user->id !== auth()->id())
                    <div class="mt-6 pt-4 border-t border-red-200">
                        <h3 class="text-md font-semibold text-red-800 mb-3">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Danger Zone
                        </h3>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition flex items-center justify-center"
                                onclick="return confirm('Yakin hapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan!')">
                                <i class="fas fa-trash mr-2"></i> Delete User Permanently
                            </button>
                        </form>
                    </div>
                @endif
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

    <script>
        // Auto hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('[class*="fixed"]');
            flashMessages.forEach(msg => msg.remove());
        }, 5000);
    </script>
</body>

</html>
