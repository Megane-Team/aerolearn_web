<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index()
    {
        return view('pelatihan.index', [
            'data' => Pelatihan::get()
        ]);
    }
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'koordinator' => 'required|string|max:255',
            'kategori' => 'required',
        ]);
        Pelatihan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'koordinator' => $request->koordinator,
            'kategori' => $request->kategori,
        ]);
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'koordinator' => 'required|string|max:255',
            'kategori' => 'required',
        ]);
        Pelatihan::where('id', $id)->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'koordinator' => $request->koordinator,
            'kategori' => $request->kategori,
        ]);
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function hapus($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
