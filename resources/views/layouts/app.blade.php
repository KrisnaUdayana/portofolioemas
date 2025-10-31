<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Gold Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-gold-dark font-bold text-xl">🏦 GoldPortfolio</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gold-dark">Dashboard</a>
                    <a href="{{ route('gold.prices') }}" class="text-gray-700 hover:text-gold-dark">Harga Emas</a>
                    <a href="{{ route('calculator') }}" class="text-gray-700 hover:text-gold-dark">Kalkulator</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <p class="text-center text-gray-600">&copy; 2024 Gold Portfolio. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
