<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::get();
        return view('alat.index', ['data' => $alat]);
    }
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        Alat::create([
            'nama' => $request->nama,
        ]);
        return redirect()->route('alat.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function update($id, Request $request)
    {
        $alat = Alat::findOrFail($id);
        $alat->nama = $request->nama;
        $alat->save();
        return redirect()->route('alat.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function hapus($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();
        return redirect()->route('alat.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
