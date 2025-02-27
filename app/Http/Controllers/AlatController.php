<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // Alat::create([
        //     'nama' => $request->nama,
        // ]);
        $berhasil = $this->postAlat(
            $request->nama
        );
        if (!$berhasil) {
            return redirect()->route('alat.index')->with('error', 'Data alat gagal disimpan.');
        }else{
            return redirect()->route('alat.index')->with('success', 'Data alat berhasil disimpan.');
        }
    }

    private function postAlat($nama) { 
        try { 
            $token = session('api_token');
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/alat/+', [ 
                'nama' => $nama, 
            ]); 

            if ($response->successful()) {
                Alat::create([
                    'nama' => $nama,
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
        // $alat = Alat::findOrFail($id);
        // $alat->nama = $request->nama;
        // $alat->save();
        $berhasil = $this->updateDataUser(
            $id,
            $request->nama
        );

        if( !$berhasil ){
            return redirect()->route('alat.index')->with('error', 'Data alat gagal disimpan.');
        }else{
            return redirect()->route('alat.index')->with('success', 'Data alat berhasil disimpan.');
        }
    }

    private function updateDataUser($id, $nama) { 
        try {
            $url = config('app.api_base_url');
            $token = session('api_token');
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/alat/update/'.$id, [ 
                'nama' => $nama,
            ]); 
    
            if ($response->successful()) { 
                $alat = Alat::findOrFail($id);
                $alat->nama = $nama;
                $alat->save();
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
        // $alat = Alat::findOrFail($id);
        // $alat->delete();
        $berhasil = $this->deleteDataAlat($id);
        if( !$berhasil){
            return redirect()->route('alat.index')->with('error', 'Data alat gagal dihapus.');
        }else{
            return redirect()->route('alat.index')->with('success', 'Data alat berhasil dihapus.');
        }
    }
    private function deleteDataAlat($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/alat/delete/' . $id,);
            if ($response->successful()) { 
                $alat = Alat::findOrFail($id);
                $alat->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
