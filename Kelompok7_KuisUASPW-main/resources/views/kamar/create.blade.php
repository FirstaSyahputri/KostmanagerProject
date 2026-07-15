@extends('layouts.app')
@section('title', 'Tambah Kamar')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Tambah Kamar Baru</h1>

    <form action="{{ route('kamar.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kamar</label>
            <input type="text" name="nomor_kamar" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" placeholder="Cth: A01" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
            <select name="tipe" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                <option value="standard">Standard</option>
                <option value="deluxe">Deluxe</option>
                <option value="vip">VIP</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Bulanan</label>
            <input type="number" name="harga_bulanan" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" placeholder="0" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
            <textarea name="fasilitas" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('kamar.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
