<?php

namespace App\Http\Controllers;

use App\Models\KontrakSewa;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakSewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontraks = KontrakSewa::with(['kamar', 'penyewa'])
                    ->latest()
                    ->get();

        return view('kontrak-sewa.index', compact('kontraks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamars = Kamar::where('status', 'tersedia')->get();
        $penyewas = Penyewa::orderBy('nama_lengkap', 'asc')->get();

        return view('kontrak-sewa.create', compact('kamars', 'penyewas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'penyewa_id' => 'required|exists:penyewa,id',
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'harga_bulanan' => 'required|numeric|min:0',
        ]);


    DB::transaction(function () use ($validated) {
        $validated['status'] = 'aktif';
        KontrakSewa::create($validated);


        Kamar::where('id', $validated['kamar_id'])->update(['status' => 'terisi']);
    });


        return redirect()->route('kontrak.index')
            ->with('success', 'Kontrak berhasil dibuat. Status kamar kini Terisi.');
    }

    /**
     * Display the specified resource.
     */

        public function show(string $id)
    {

        $kontrak = KontrakSewa::with(['kamar', 'penyewa', 'pembayarans'])->findOrFail($id);
        return view('kontrak-sewa.show', compact('kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kontrak = KontrakSewa::findOrFail($id);


        $kamars = Kamar::all();
        $penyewas = Penyewa::all();


        return view('kontrak-sewa.edit', compact('kontrak', 'kamars', 'penyewas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kontrak = KontrakSewa::findOrFail($id);

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'harga_bulanan' => 'required|numeric',
            'status' => 'required|in:aktif,selesai',
        ]);

        DB::transaction(function () use ($kontrak, $validated) {

                        if ($kontrak->status == 'aktif' && $validated['status'] == 'selesai') {
                $kontrak->kamar()->update(['status' => 'tersedia']);
            }


            if ($kontrak->status == 'selesai' && $validated['status'] == 'aktif') {
                $kontrak->kamar()->update(['status' => 'terisi']);
            }

            $kontrak->update($validated);
        });

        return redirect()->route('kontrak.index')
            ->with('success', 'Data kontrak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kontrak = KontrakSewa::findOrFail($id);

        DB::transaction(function () use ($kontrak) {

            if ($kontrak->status == 'aktif') {
                $kontrak->kamar()->update(['status' => 'tersedia']);
            }

            $kontrak->delete();
        });

        return redirect()->route('kontrak.index')
            ->with('success', 'Kontrak berhasil dihapus.');
    }
}
