@extends('layouts.app')
@section('title', 'Data Kamar')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Data Kamar</h1>
    <a href="{{ route('kamar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
        + Tambah Kamar
    </a>
</div>

<div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Kamar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($kamars as $kamar)
            <tr>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $kamar->nomor_kamar }}</td>
                <td class="px-6 py-4 text-gray-500 capitalize">{{ $kamar->tipe }}</td>
                <td class="px-6 py-4 text-gray-900">Rp {{ number_format($kamar->harga_bulanan, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $kamar->status == 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($kamar->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('kamar.edit', $kamar->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                    <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kamar.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
