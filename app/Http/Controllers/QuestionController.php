<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\JawabanBenar;
use App\Models\OpsiJawaban;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($id){
        return view('pelatihan.question',[
            'data' => Exam::findOrFail($id)
        ]);
    }
    public function tambah(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'question' => 'required|string',
            'gambar' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Maksimal 2MB dan hanya file gambar
            'id_exam' => 'required|integer',
            'opsi' => 'required|array|min:2', // Pastikan opsi adalah array dengan minimal 2 item
            'opsi.*' => 'required|string|max:255', // Setiap item dalam array opsi harus string dengan maksimal 255 karakter
            'jawaban' => 'required|string|in:' . implode(',', $request->opsi), // Jawaban harus salah satu dari opsi
        ]);
        // Inisialisasi nama file
        $gambar = null;

        // Cek apakah file diunggah
        if ($request->hasFile('gambar')) {
            // Ambil file dari request
            $file = $request->file('gambar');

            // Tentukan nama unik untuk file
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tentukan lokasi penyimpanan
            $destinationPath = public_path('question');

            // Pindahkan file ke lokasi penyimpanan
            $file->move($destinationPath, $fileName);

            // Simpan nama file untuk disimpan di database
            $gambar = 'question/' . $fileName;
        }
        $q = Question::create([
            'question' => $request->question,
            'gambar' => $gambar,
            'id_exam' => $request->id_exam
        ]);
        foreach ($request->opsi as $key => $value) {
            OpsiJawaban::create([
                'jawaban' => $value,
                'id_question' => $q->id
            ]);
        }
        JawabanBenar::create([
            'text' => $request->jawaban,
            'id_question' => $q->id
        ]);
        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function hapus($id)
    {
        $data = Question::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
