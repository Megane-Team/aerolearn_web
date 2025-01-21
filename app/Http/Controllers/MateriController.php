<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'id_pelatihan' => 'required|integer',
        ]);

        // Inisialisasi nama file

        // Cek apakah file diunggah
        // if ($request->hasFile('materi')) {
        //     // Ambil file dari request
            
        // }

        $berhasil = $this->postMateriTraining(
            $validated['judul'],
            $validated['id_pelatihan'],
            $request->hasFile('materi') ? $request->file('materi') : null
        );

        // Simpan data ke database
        // Materi::create([
        //     'judul' => $validated['judul'],
        //     'konten' => $validated['konten'],
        //     'link' => $materiFile, // Nama kolom file di tabel
        //     'id_pelatihan' => $validated['id_pelatihan'],
        // ]);

        // Redirect kembali dengan pesan sukses
        if(!$berhasil){
            return back()->with('error', 'Data gagal disimpan.');
        }else{
            return back()->with('success', 'Data berhasil disimpan.');
        }
    }

    private function postMateriTraining($judul, $id_pelatihan, $file) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
            ->attach('file', file_get_contents($file), $file->getClientOriginalName())
            ->asMultipart()
            ->post($url . '/materi/+', [ 
                'judul' => $judul,
                'id_pelatihan' => $id_pelatihan,
            ]); 
    
            if ($response->successful()) { 

                $fileName = $judul . '.pdf';
                $destinationPath = public_path('materi');
                $file->move($destinationPath, $fileName);
                $materiFile = 'materi/' . $fileName;
                Materi::create([
                    'judul' => $judul,
                    'konten' => $materiFile,
                    'id_pelatihan' => $id_pelatihan,
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
        
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Maksimal 2MB
        ]);

        // Inisialisasi nama file
        // $materiFile = $data->link;

        // // Cek apakah file diunggah
        // if ($request->hasFile('materi')) {
        //     // Ambil file dari request
        //     $file = $request->file('materi');

        //     // Tentukan nama unik untuk file
        //     $fileName = time() . '_' . $file->getClientOriginalName();

        //     // Tentukan lokasi penyimpanan
        //     $destinationPath = public_path('materi');

        //     // Pindahkan file ke lokasi penyimpanan
        //     $file->move($destinationPath, $fileName);

        //     // Simpan nama file untuk disimpan di database
        //     $materiFile = 'materi/' . $fileName;
        // }

        // // Simpan data ke database
        // $data->update([
        //     'judul' => $validated['judul'],
        //     'konten' => $validated['konten'],
        //     'link' => $materiFile,
        // ]);

        $berhasil = $this->updateMateriTraining(
            $validated['judul'],
            $id,
            $request->hasFile('materi') ? $request->file('materi') : null
        );

        // Redirect kembali dengan pesan sukses
        if( !$berhasil ){
            return back()->with('error', 'Data gagal disimpan.');
        }
        else{
            return back()->with('success', 'Data berhasil disimpan.');
        }
    }

    private function updateMateriTraining($judul, $id, $file) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ]);

            if ($file) { 
                $response = $response->attach('file', file_get_contents($file), 
                $file->getClientOriginalName()); 
            } 
            
            $response = $response->asMultipart() 
            ->put($url . '/materi/update/' . $id, [ 
                'judul' => $judul, 
            ]);

            if ($response->successful()) { 
                $data = Materi::findOrFail($id);
                $materiFile = $data->konten;
                if ($file) { 
                    if (file_exists(public_path($materiFile))) { 
                        unlink(public_path($materiFile)
                    ); }
                    $destinationPath = public_path('materi');
                    $fileName = $judul . '.pdf';
                    $file->move($destinationPath, $fileName); 
                    $materiFile = 'materi/' . $fileName; 
                } else{
                    $materiFile = $data->konten;
                } 

                $data->update([
                    'judul' => $judul,
                    'konten' => $materiFile,
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
        $berhasil = $this->deleteDataMateri($id);
        if( !$berhasil){
            return back()->with('error', 'Data gagal dihapus.');
        }else{
            return back()->with('success', 'Data berhasil dihapus.');
        }
    }

    private function deleteDataMateri($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/materi/delete/' . $id,);
            if ($response->successful()) { 
                $data = Materi::findOrFail($id);
                $materiFile = $data->konten;
                if (file_exists(public_path($materiFile))) { 
                    unlink(public_path($materiFile)
                ); }
                $data->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
