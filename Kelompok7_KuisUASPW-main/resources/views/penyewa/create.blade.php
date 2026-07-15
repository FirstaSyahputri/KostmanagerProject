@extends('layouts.app')
@section('title', 'Tambah Penyewa')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Registrasi Penyewa</h1>

    <form action="{{ route('penyewa.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="w-full border-gray-300 rounded-lg p-2 border" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="w-full border-gray-300 rounded-lg p-2 border" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP</label>
            <input type="number" name="nomor_ktp" class="w-full border-gray-300 rounded-lg p-2 border" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Asal</label>
            <textarea name="alamat_asal" rows="2" class="w-full border-gray-300 rounded-lg p-2 border"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan" class="w-full border-gray-300 rounded-lg p-2 border">
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('penyewa.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
