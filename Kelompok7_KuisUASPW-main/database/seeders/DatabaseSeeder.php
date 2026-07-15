<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\KontrakSewa;
use App\Models\Pembayaran;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        for ($i = 1; $i <= 10; $i++) {
            Kamar::create([
                'nomor_kamar' => 'A' . $i,
                'tipe' => $i % 2 == 0 ? 'standard' : 'deluxe',
                'harga_bulanan' => $i % 2 == 0 ? 800000 : 1200000,
                'fasilitas' => 'Kasur, Lemari, WiFi',
                'status' => 'tersedia'
            ]);
        }

        Penyewa::create([
            'nama_lengkap' => 'Firsta Khory',
            'nomor_telepon' => '081234567890',
            'nomor_ktp' => '3201234567890001',
            'alamat_asal' => 'Jakarta',
            'pekerjaan' => 'Mahasiswa'
        ]);

        $kamar = Kamar::first();
        $penyewa = Penyewa::first();

        $kontrak = KontrakSewa::create([
            'penyewa_id' => $penyewa->id,
            'kamar_id' => $kamar->id,
            'tanggal_mulai' => now()->subMonths(2),
            'tanggal_selesai' => now()->addMonths(10),
            'harga_bulanan' => 800000,
            'status' => 'aktif'
        ]);

        $kamar->update(['status' => 'terisi']);

        Pembayaran::create([
            'kontrak_sewa_id' => $kontrak->id,
            'bulan' => now()->subMonths(1)->month,
            'tahun' => now()->year,
            'jumlah_bayar' => 800000,
            'tanggal_bayar' => now()->subMonths(1),
            'status' => 'lunas'
        ]);
    }
}
