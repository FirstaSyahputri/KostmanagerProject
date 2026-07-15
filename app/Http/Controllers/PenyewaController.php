<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyewa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon', 'like', "%{$search}%");
            });
        }

        $penyewas = $query->latest()->get();
        return view('penyewa.index', compact('penyewas'));
    }

    public function create()
    {
        return view('penyewa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:15',
            'nomor_ktp' => 'required|numeric|unique:penyewa,nomor_ktp',
            'alamat_asal' => 'required|string',
            'pekerjaan' => 'required|string|max:50',
        ]);

        Penyewa::create($validated);
        return redirect()->route('penyewa.index')->with('success', 'Data penyewa ditambahkan.');
    }

    public function edit(string $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        return view('penyewa.edit', compact('penyewa'));
    }

    public function update(Request $request, string $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:15',
            'nomor_ktp' => 'required|numeric|unique:penyewa,nomor_ktp,' . $penyewa->id,
            'alamat_asal' => 'required|string',
            'pekerjaan' => 'required|string|max:50',
        ]);

        $penyewa->update($validated);
        return redirect()->route('penyewa.index')->with('success', 'Data penyewa diperbarui.');
    }

public function destroy(string $id)
{
    $penyewa = Penyewa::findOrFail($id);

    if ($penyewa->kontrak_sewas()->exists()) {
        return back()->with('error', 'Gagal menghapus! Penyewa ini memiliki riwayat kontrak sewa.');
    }

    $penyewa->delete();
    return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil dihapus.');
}
}
