<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
        $this->postDataTraining(
            $request->nama,
            $request->deskripsi,
            $request->koordinator,
            $request->kategori
        );
        return back()->with('success', 'Data berhasil disimpan.');
    }

    private function postDataTraining($nama, $deskripsi, $koordinator, $kategori) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/training/+', [ 
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'koordinator' => $koordinator,
                'kategori' => $kategori,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');
                $pelatihan = Pelatihan::create([
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'koordinator' => $koordinator,
                    'kategori' => $kategori,
                ]);

                Exam::create([
                    'judul' => $nama,
                    'id_pelatihan' => $pelatihan->id
                ]);

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'koordinator' => 'required|string|max:255',
            'kategori' => 'required',
        ]);
        $this->updateDataTraining(
            $id,
            $request->nama,
            $request->deskripsi,
            $request->koordinator,
            $request->kategori
        );
        return back()->with('success', 'Data berhasil disimpan.');
    }

    private function updateDataTraining($id, $nama, $deskripsi, $koordinator, $kategori) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/training/update/'.$id, [ 
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'koordinator' => $koordinator,
                'kategori' => $kategori,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');
                Pelatihan::where('id', $id)->update([
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'koordinator' => $koordinator,
                    'kategori' => $kategori,
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
        // $pelatihan = Pelatihan::findOrFail($id);
        // $pelatihan->delete();
        $this->deleteDataTraining($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    private function deleteDataTraining($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/training/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $exam = Exam::where('id_pelatihan', $id)->delete();
                $pelatihan = Pelatihan::findOrFail($id); 
                $pelatihan->delete();
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
