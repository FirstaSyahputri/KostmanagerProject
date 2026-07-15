@extends('layouts.app')
@section('title', 'Catat Pembayaran')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-xl font-bold text-gray-900 mb-6">Catat Pembayaran</h1>

    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kontrak</label>
            <select name="kontrak_sewa_id" id="kontrak_id" class="w-full border-gray-300 rounded-lg p-2 border bg-white" required>
                <option value="" data-tagihan="">-- Pilih Penyewa/Kamar --</option>
                @foreach($kontraks as $k)
                    <option value="{{ $k->id }}" data-tagihan="{{ $k->harga_bulanan }}">
                        {{ $k->kamar->nomor_kamar }} - {{ $k->penyewa->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <input type="number" name="bulan" value="{{ date('n') }}" class="w-full border-gray-300 rounded-lg p-2 border" min="1" max="12" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full border-gray-300 rounded-lg p-2 border" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="w-full border-gray-300 rounded-lg p-2 border" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg p-2 border" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg p-2 border bg-white">
                <option value="lunas">Lunas</option>
                <option value="tertunggak">Tertunggak</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti_transfer" class="w-full border-gray-300 rounded-lg p-2 border bg-gray-50 text-sm">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('pembayaran.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('kontrak_id').addEventListener('change', function() {
        var tagihan = this.options[this.selectedIndex].getAttribute('data-tagihan');
        document.getElementById('jumlah_bayar').value = tagihan;
    });
</script>
@endsection
