<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex flex-col justify-center items-center px-4">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">KostManager</h1>
        <p class="mt-4 text-lg text-gray-600">Kelola kamar, penyewa, dan keuangan dengan mudah.</p>
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg shadow-sm transition">
                Masuk ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
