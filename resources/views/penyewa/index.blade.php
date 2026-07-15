@extends('layouts.app')
@section('title', 'Data Penyewa')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <h1 class="text-2xl font-bold text-gray-900">Data Penyewa</h1>
    <div class="flex gap-2 w-full md:w-auto">
        <form action="{{ route('penyewa.index') }}" method="GET" class="flex w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / telepon..." class="border-gray-300 rounded-l-lg p-2 border focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
            <button type="submit" class="bg-gray-200 px-4 rounded-r-lg border border-l-0 border-gray-300 hover:bg-gray-300">🔍</button>
        </form>
        <a href="{{ route('penyewa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium whitespace-nowrap">
            + Tambah
        </a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($penyewas as $penyewa)
            <tr>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $penyewa->nama_lengkap }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $penyewa->nomor_telepon }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $penyewa->alamat_asal }}</td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('penyewa.edit', $penyewa->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    <form action="{{ route('penyewa.destroy', $penyewa->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
