<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Kesehatan - {{ $title ?? 'Marketplace' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <i class="fas fa-stethoscope text-blue-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">Toko Alat Kesehatan</span>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('products.index') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium">Produk</a>

                    @auth
                        <!-- Untuk yang sudah login -->
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Dashboard
                        </a>
                    @else
                        <!-- Untuk visitor -->
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2024 Toko Alat Kesehatan. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
