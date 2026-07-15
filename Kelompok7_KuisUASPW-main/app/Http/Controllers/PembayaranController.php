<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\KontrakSewa;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['kontrak_sewa.penyewa', 'kontrak_sewa.kamar'])
                        ->latest()
                        ->get();

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $kontraks = KontrakSewa::with(['penyewa', 'kamar'])
                    ->where('status', 'aktif')
                    ->get();

        return view('pembayaran.create', compact('kontraks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kontrak_sewa_id' => 'required|exists:kontrak_sewa,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|digits:4',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,tertunggak',
            'keterangan' => 'nullable|string',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $validated['bukti_transfer'] = $path;
        }

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function edit(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $kontraks = KontrakSewa::with(['penyewa', 'kamar'])->get();

        return view('pembayaran.edit', compact('pembayaran', 'kontraks'));
    }

    public function update(Request $request, string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $validated = $request->validate([
            'kontrak_sewa_id' => 'required|exists:kontrak_sewa,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|digits:4',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,tertunggak',
            'keterangan' => 'nullable|string',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
                Storage::disk('public')->delete($pembayaran->bukti_transfer);
            }
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $validated['bukti_transfer'] = $path;
        }

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran diperbarui.');
    }

    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
            Storage::disk('public')->delete($pembayaran->bukti_transfer);
        }

        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran dihapus.');
    }

    public function export()
    {
        $pembayarans = Pembayaran::with(['kontrak_sewa.penyewa', 'kontrak_sewa.kamar'])->get();

        $filename = "laporan_pembayaran_" . date('Ymd') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, ['Tanggal', 'Kamar', 'Penyewa', 'Bulan/Tahun', 'Jumlah', 'Status']);

        foreach ($pembayarans as $p) {
            fputcsv($handle, [
                $p->tanggal_bayar->format('Y-m-d'),
                $p->kontrak_sewa->kamar->nomor_kamar,
                $p->kontrak_sewa->penyewa->nama_lengkap,
                $p->bulan . '/' . $p->tahun,
                $p->jumlah_bayar,
                $p->status
            ]);
        }

        fclose($handle);
        exit;
    }
}
