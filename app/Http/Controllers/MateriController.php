<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index($id)
    {
        return view('pelatihan.materi', [
            'data' => Pelatihan::findOrFail($id)
        ]);
    }
    public function tambah(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'nullable|string',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Maksimal 2MB
            'id_pelatihan' => 'required|integer',
        ]);

        // Inisialisasi nama file
        $materiFile = null;

        // Cek apakah file diunggah
        if ($request->hasFile('materi')) {
            // Ambil file dari request
            $file = $request->file('materi');

            // Tentukan nama unik untuk file
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tentukan lokasi penyimpanan
            $destinationPath = public_path('materi');

            // Pindahkan file ke lokasi penyimpanan
            $file->move($destinationPath, $fileName);

            // Simpan nama file untuk disimpan di database
            $materiFile = 'materi/' . $fileName;
        }

        // Simpan data ke database
        Materi::create([
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'link' => $materiFile, // Nama kolom file di tabel
            'id_pelatihan' => $validated['id_pelatihan'],
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan.');
    }

    public function update($id, Request $request)
    {
        $data = Materi::findOrFail($id);
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'nullable|string',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Maksimal 2MB
        ]);

        // Inisialisasi nama file
        $materiFile = $data->link;

        // Cek apakah file diunggah
        if ($request->hasFile('materi')) {
            // Ambil file dari request
            $file = $request->file('materi');

            // Tentukan nama unik untuk file
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tentukan lokasi penyimpanan
            $destinationPath = public_path('materi');

            // Pindahkan file ke lokasi penyimpanan
            $file->move($destinationPath, $fileName);

            // Simpan nama file untuk disimpan di database
            $materiFile = 'materi/' . $fileName;
        }

        // Simpan data ke database
        $data->update([
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'link' => $materiFile,
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function hapus($id)
    {
        $data = Materi::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
