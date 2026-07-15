@extends('layouts.app')
@section('title', 'Data Pembayaran')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Pembayaran</h1>
    <div class="flex gap-2">
        <a href="{{ route('pembayaran.export') }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
            Download Excel
        </a>
        <a href="{{ route('pembayaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
            + Catat Bayar
        </a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar/Penyewa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($pembayarans as $p)
            <tr>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $p->tanggal_bayar->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="text-gray-900 font-medium">{{ $p->kontrak_sewa->kamar->nomor_kamar }}</div>
                    <div class="text-gray-500 text-xs">{{ $p->kontrak_sewa->penyewa->nama_lengkap }}</div>
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $p->bulan }} / {{ $p->tahun }}</td>
                <td class="px-6 py-4 text-gray-900">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @if($p->bukti_transfer)
                        <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat Foto</a>
                    @else
                        <span class="text-gray-400 text-xs">-</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $p->status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
