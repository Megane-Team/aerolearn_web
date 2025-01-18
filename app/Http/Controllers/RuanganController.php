<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::get();
        return view('ruangan.index', ['data' => $ruangan]);
    }
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'status_ruangan' => 'required'
        ]);
        Ruangan::create([
            'nama' => $request->nama,
            'status_ruangan' => $request->status_ruangan
        ]);
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function update($id, Request $request)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->nama = $request->nama;
        $ruangan->status_ruangan = $request->status_ruangan;
        $ruangan->save();
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function hapus($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
