<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Kost frista')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600 tracking-tight">
                        KostManager
                    </a>

                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600' }}">Dashboard</a>
                        <a href="{{ route('kamar.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('kamar.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600' }}">Kamar</a>
                        <a href="{{ route('penyewa.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('penyewa.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600' }}">Penyewa</a>
                        <a href="{{ route('kontrak.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('kontrak.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600' }}">Kontrak</a>
                        <a href="{{ route('pembayaran.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pembayaran.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600' }}">Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Sistem Manajemen Kost fRISTA.
        </div>
    </footer>
</body>
</html>
