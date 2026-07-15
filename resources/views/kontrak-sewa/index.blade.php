@extends('layouts.app')
@section('title', 'Data Kontrak Sewa')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Kontrak Sewa</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data penyewaan kamar aktif dan riwayatnya.</p>
    </div>
    {{-- Perhatikan route-nya, sesuaikan jika di web.php Anda pakai 'kontrak' atau 'kontrak-sewa' --}}
    <a href="{{ route('kontrak.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium shadow-sm transition">
        + Buat Kontrak Baru
    </a>
</div>

<div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Sewa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Deal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($kontraks as $kontrak)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Info Kamar --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">{{ $kontrak->kamar->nomor_kamar }}</div>
                        <div class="text-xs text-gray-500 capitalize">{{ $kontrak->kamar->tipe }}</div>
                    </td>

                    {{-- Info Penyewa --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $kontrak->penyewa->nama_lengkap }}</div>
                        <div class="text-xs text-gray-500">{{ $kontrak->penyewa->nomor_telepon }}</div>
                    </td>

                    {{-- Periode --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>Mulai: {{ $kontrak->tanggal_mulai->format('d/m/Y') }}</div>
                        <div>Selesai: {{ $kontrak->tanggal_selesai->format('d/m/Y') }}</div>
                    </td>

                    {{-- Harga --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        Rp {{ number_format($kontrak->harga_bulanan, 0, ',', '.') }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($kontrak->status == 'aktif')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                Selesai
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('kontrak.edit', $kontrak->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded-md transition">Edit</a>

                        <form action="{{ route('kontrak.destroy', $kontrak->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini? Data pembayaran terkait juga akan hilang.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-base font-medium text-gray-900">Belum ada kontrak sewa</p>
                            <p class="text-sm text-gray-500 mb-4">Silakan buat kontrak baru untuk memulai sewa.</p>
                            <a href="{{ route('kontrak.create') }}" class="text-blue-600 hover:underline">Buat Kontrak Baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
