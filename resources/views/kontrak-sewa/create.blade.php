@extends('layouts.app')
@section('title', 'Buat Kontrak Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Buat Kontrak Sewa</h1>
        <p class="text-sm text-gray-500">Hubungkan penyewa dengan kamar yang tersedia.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Header Info --}}
        <div class="bg-blue-50 border-b border-blue-100 px-6 py-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm text-blue-700">
                    Membuat kontrak akan otomatis mengubah status kamar menjadi <strong>Terisi</strong>. Pastikan data sudah benar.
                </p>
            </div>
        </div>

        <form action="{{ route('kontrak.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- 1. Pilih Penyewa --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Penyewa</label>
                <select name="penyewa_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 border bg-white" required>
                    <option value="">-- Cari Nama Penyewa --</option>
                    @foreach($penyewas as $penyewa)
                        <option value="{{ $penyewa->id }}" {{ old('penyewa_id') == $penyewa->id ? 'selected' : '' }}>
                            {{ $penyewa->nama_lengkap }} ({{ $penyewa->nomor_ktp }})
                        </option>
                    @endforeach
                </select>
                <div class="mt-1 text-xs text-gray-500">
                    Penyewa tidak ada? <a href="{{ route('penyewa.create') }}" class="text-blue-600 hover:underline">Tambah data penyewa dulu</a>.
                </div>
            </div>

            {{-- 2. Pilih Kamar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamar (Tersedia)</label>
                <select name="kamar_id" id="kamar_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 border bg-white" required>
                    <option value="" data-harga="">-- Pilih Kamar Kosong --</option>
                    @foreach($kamars as $kamar)
                        <option value="{{ $kamar->id }}"
                                data-harga="{{ $kamar->harga_bulanan }}"
                                {{ old('kamar_id') == $kamar->id ? 'selected' : '' }}>
                            No. {{ $kamar->nomor_kamar }} - {{ ucfirst($kamar->tipe) }} (Rp {{ number_format($kamar->harga_bulanan, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Periode Sewa --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-2 border focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full border-gray-300 rounded-lg shadow-sm p-2 border focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
            </div>

            {{-- 4. Harga Deal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa per Bulan (Deal)</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_bulanan" id="harga_bulanan" value="{{ old('harga_bulanan') }}"
                           class="w-full border-gray-300 rounded-lg pl-10 p-2 border bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                           placeholder="0" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Harga otomatis terisi sesuai kamar, tapi bisa diedit jika ada kesepakatan khusus.</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('kontrak.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm font-medium transition">
                    Buat Kontrak
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Auto-fill Harga --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kamarSelect = document.getElementById('kamar_id');
        const hargaInput = document.getElementById('harga_bulanan');

        kamarSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');

            if(harga) {
                hargaInput.value = harga;
                hargaInput.classList.add('bg-yellow-50');
                setTimeout(() => hargaInput.classList.remove('bg-yellow-50'), 500);
            } else {
                hargaInput.value = '';
            }
        });
    });
</script>
@endsection
