@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 font-medium">Total Kamar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKamar }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 font-medium">Terisi</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $kamarTerisi }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 font-medium">Pendapatan (Bulan Ini)</p>
            <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 font-medium">Tunggakan</p>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $pembayaranTertunggak }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pendapatan 6 Bulan Terakhir</h3>
            <canvas id="incomeChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Belum Bayar Bulan Ini</h3>
            <div class="overflow-y-auto max-h-64">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-2 px-2 text-xs text-gray-500">Kamar</th>
                            <th class="text-left py-2 px-2 text-xs text-gray-500">Penyewa</th>
                            <th class="text-right py-2 px-2 text-xs text-gray-500">Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($belumBayarBulanIni as $kontrak)
                        <tr class="border-b">
                            <td class="py-2 px-2 font-bold">{{ $kontrak->kamar->nomor_kamar }}</td>
                            <td class="py-2 px-2">{{ $kontrak->penyewa->nama_lengkap }}</td>
                            <td class="py-2 px-2 text-right">Rp {{ number_format($kontrak->harga_bulanan) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-gray-500 text-sm">Semua lunas bulan ini!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($chartData['values']),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
