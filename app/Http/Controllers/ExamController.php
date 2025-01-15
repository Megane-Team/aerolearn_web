<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\JawabanBenar;
use App\Models\OpsiJawaban;
use App\Models\Pelatihan;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index($id){
        return view('pelatihan.exam',[
            'data' => Pelatihan::findOrFail($id)
        ]);
    }
    public function tambah(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
        ]);
        
        $exam = Exam::create([
            'judul' => $request->judul,
            'id_pelatihan' => $request->id_pelatihan
        ]);
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
        ]);
        Pelatihan::where('id', $id)->update([
            'judul' => $request->nama,
        ]);
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function hapus($id)
    {
        $data = Exam::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
