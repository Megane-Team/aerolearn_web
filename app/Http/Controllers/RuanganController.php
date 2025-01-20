<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // Ruangan::create([
        //     'nama' => $request->nama,
        //     'status_ruangan' => $request->status_ruangan
        // ]);
        $this->postRuangan(
            $request->nama,
            $request->status_ruangan
        );
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil disimpan.');
    }

    private function postRuangan($nama, $status_ruangan) { 
        try { 
            $token = session('api_token');
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/ruangan/+', [ 
                'nama' => $nama, 
                'status_ruangan' => $status_ruangan, 
            ]); 
                    
            if ($response->successful()) {
                Ruangan::create([
                    'nama' => $nama,
                    'status_ruangan' => $status_ruangan
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
        // $ruangan = Ruangan::findOrFail($id);
        // $ruangan->nama = $request->nama;
        // $ruangan->status_ruangan = $request->status_ruangan;
        // $ruangan->save();
        $this->updateDataRuangan(
            $id,
            $request->nama,
            $request->status_ruangan
        );
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil disimpan.');
    }

    private function updateDataRuangan($id, $nama, $status_ruangan) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/ruangan/update/'.$id, [ 
                'nama' => $nama,
                'status_ruangan' => $status_ruangan,
            ]); 
    
            if ($response->successful()) { 
                $ruangan = Ruangan::findOrFail($id);
                $ruangan->nama = $nama;
                $ruangan->status_ruangan = $status_ruangan;
                $ruangan->save();

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
        // $ruangan = Ruangan::findOrFail($id);
        // $ruangan->delete();
        $this->deleteDataRuangan($id);
        return redirect()->route('ruangan.index')->with('success', 'Data peserta berhasil dihapus.');
    }

    private function deleteDataRuangan($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/ruangan/delete/' . $id,);
            if ($response->successful()) { 
                $ruangan = Ruangan::findOrFail($id);
                $ruangan->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
