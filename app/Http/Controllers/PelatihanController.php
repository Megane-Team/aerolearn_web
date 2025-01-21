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
        $berhasil = $this->postDataTraining(
            $request->nama,
            $request->deskripsi,
            $request->koordinator,
            $request->kategori
        );

        if( !$berhasil ){
            return back()->with('error', 'Data gagal disimpan.');
        }else{
            return back()->with('success', 'Data berhasil disimpan.');
        }
    }

    private function postDataTraining($nama, $deskripsi, $koordinator, $kategori) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/training/+', [ 
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'koordinator' => $koordinator,
                'kategori' => $kategori,
            ]); 
    
            if ($response->successful()) { 
                $pelatihan = Pelatihan::create([
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'koordinator' => $koordinator,
                    'kategori' => $kategori,
                ]);

                Exam::create([
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
        $berhasil = $this->updateDataTraining(
            $id,
            $request->nama,
            $request->deskripsi,
            $request->koordinator,
            $request->kategori
        );

        if( !$berhasil ){
            return back()->with('error', 'Data gagal disimpan.');
        }else{
            return back()->with('success', 'Data berhasil disimpan.');
        }
    }

    private function updateDataTraining($id, $nama, $deskripsi, $koordinator, $kategori) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/training/update/'.$id, [ 
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'koordinator' => $koordinator,
                'kategori' => $kategori,
            ]); 
    
            if ($response->successful()) { 
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
        $berhasil = $this->deleteDataTraining($id);
        if( !$berhasil ){
            return back()->with('error', 'Data gagal dihapus.');
        }else{
            return back()->with('success', 'Data berhasil dihapus.');
        }
    }

    private function deleteDataTraining($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/training/delete/' . $id,);
            if ($response->successful()) { 
                Exam::where('id_pelatihan', $id)->delete();
                $pelatihan = Pelatihan::findOrFail($id); 
                $pelatihan->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
