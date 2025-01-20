<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\JawabanBenar;
use App\Models\OpsiJawaban;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
        // $validated = $request->validate([
        //     'question' => 'required|string',
        //     'gambar' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Maksimal 2MB dan hanya file gambar
        //     'id_exam' => 'required|integer',
        //     'opsi' => 'required|array|min:2', // Pastikan opsi adalah array dengan minimal 2 item
        //     'opsi.*' => 'required|string|max:255', // Setiap item dalam array opsi harus string dengan maksimal 255 karakter
        //     'jawaban' => 'required|string|in:' . implode(',', $request->opsi), // Jawaban harus salah satu dari opsi
        // ]);
        // // Inisialisasi nama file
        // $gambar = null;

        // // Cek apakah file diunggah
        // if ($request->hasFile('gambar')) {
        //     // Ambil file dari request
        //     $file = $request->file('gambar');

        //     // Tentukan nama unik untuk file
        //     $fileName = time() . '_' . $file->getClientOriginalName();

        //     // Tentukan lokasi penyimpanan
        //     $destinationPath = public_path('question');

        //     // Pindahkan file ke lokasi penyimpanan
        //     $file->move($destinationPath, $fileName);

        //     // Simpan nama file untuk disimpan di database
        //     $gambar = 'question/' . $fileName;
        // }
        // $q = Question::create([
        //     'question' => $request->question,
        //     'gambar' => $gambar,
        //     'id_exam' => $request->id_exam
        // ]);
        // foreach ($request->opsi as $key => $value) {
        //     OpsiJawaban::create([
        //         'jawaban' => $value,
        //         'id_question' => $q->id
        //     ]);
        // }
        // JawabanBenar::create([
        //     'text' => $request->jawaban,
        //     'id_question' => $q->id
        // ]);
        // Redirect kembali dengan pesan sukses

        $this->postDataQuestion($request);
        return back()->with('success', 'Data berhasil disimpan.');
    }

    private function postDataQuestion(Request $request) { 
        try { 
            $validated = $request->validate([
                'question' => 'required|string',
                'gambar' => 'nullable|file|mimes:jpg,png,jpeg|max:2048', // Maksimal 2MB dan hanya file gambar
                'id_exam' => 'required|integer',
                'opsi' => 'required|array|min:2', // Pastikan opsi adalah array dengan minimal 2 item
                'opsi.*' => 'required|string|max:255', // Setiap item dalam array opsi harus string dengan maksimal 255 karakter
                'jawaban' => 'required|string|in:' . implode(',', $request->opsi), // Jawaban harus salah satu dari opsi
            ]);

            $gambar = null;
            $url = config('app.api_base_url');
            $token = session('api_token');
            $gambar = $validated['gambar'] ?? null;

            $response = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token, ]); 
            if ($gambar) { $response = $response->attach('file', file_get_contents($gambar), $gambar->getClientOriginalName()); }
            $response = $response->asMultipart()->post($url . '/exam/question/+', [
                'question'=> $validated['question'],
                'id_exam' => $validated['id_exam'],
            ]); 
    
            if ($response->successful()) { 
                if ($request->hasFile('gambar')) {
                    $file = $gambar;
                    $fileName = $file->getClientOriginalName();
                    $destinationPath = public_path('question');
                    $file->move($destinationPath, $fileName);
                    $gambar = 'question/' . $fileName;
                }
                $q = Question::create([
                    'question' => $validated['question'],
                    'gambar' => $gambar,
                    'id_exam' => $validated['id_exam']
                ]);
                foreach ($request->opsi as $key => $value) {
                    $this->postDataOptions($value, $q->id);
                }

                $this->postTrueAnswer($request->jawaban, $q->id);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }

    private function postDataOptions($jawaban, $id_question) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');

            $response = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token, ]); 
            $response = $response->post($url . '/exam/question/opsi/+', [
                'jawaban' => $jawaban,
                'id_question' => $id_question,
            ]); 
    
            if ($response->successful()) { 
                OpsiJawaban::create([
                    'jawaban' => $jawaban,
                    'id_question' => $id_question
                ]);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }

    private function postTrueAnswer($text, $id_question) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');

            $response = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token, ]); 
            $response = $response->post($url . '/exam/question/true_answer/+', [
                'text' => $text,
                'id_question' => $id_question,
            ]); 
    
            if ($response->successful()) { 
                JawabanBenar::create([
                    'text' => $text,
                    'id_question' => $id_question
                ]);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }

    public function hapus($id)
    {
        $this->deleteDataTraining($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    private function deleteDataTraining($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/exam/question/delete/' . $id,);
            if ($response->successful()) { 
                $data = Question::findOrFail($id);
                $data->delete();
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
