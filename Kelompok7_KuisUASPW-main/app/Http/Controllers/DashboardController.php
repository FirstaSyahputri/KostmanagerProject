<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\KontrakSewa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::where('status', 'terisi')->count();
        $kamarTersedia = Kamar::where('status', 'tersedia')->count();

        $pendapatanBulanIni = Pembayaran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah_bayar');

        $pembayaranTertunggak = Pembayaran::where('status', 'tertunggak')->count();

        $bulanIni = now()->month;
        $tahunIni = now()->year;

    $belumBayarBulanIni = KontrakSewa::where('status', 'aktif')
        ->whereDoesntHave('pembayarans', function($q) use ($bulanIni, $tahunIni) {
            $q->where('bulan', $bulanIni)->where('tahun', $tahunIni);
        })->with(['penyewa', 'kamar'])->get();

        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartData['labels'][] = $date->format('F');
            $chartData['values'][] = Pembayaran::whereMonth('tanggal_bayar', $date->month)
                                        ->whereYear('tanggal_bayar', $date->year)
                                        ->sum('jumlah_bayar');
        }

        return view('dashboard.index', compact(
            'totalKamar', 'kamarTerisi', 'kamarTersedia',
            'pendapatanBulanIni', 'pembayaranTertunggak',
            'belumBayarBulanIni', 'chartData'
        ));
    }
}
