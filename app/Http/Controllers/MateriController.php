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
            'konten' => 'nullable|string',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // Maksimal 2MB
            'id_pelatihan' => 'required|integer',
        ]);

        // Inisialisasi nama file

        // Cek apakah file diunggah
        // if ($request->hasFile('materi')) {
        //     // Ambil file dari request
            
        // }

        $this->postMateriTraining(
            $validated['judul'],
            $validated['konten'],
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
        return back()->with('success', 'Data berhasil disimpan.');
    }

    private function postMateriTraining($judul, $konten, $id_pelatihan, $file) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
            ->attach('file', file_get_contents($file), $file->getClientOriginalName())
            ->asMultipart()
            ->post($url . '/materi/+', [ 
                'judul' => $judul,
                'konten' => $konten,
                'id_pelatihan' => $id_pelatihan,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');

                $fileName = $judul . '.pdf';
                $destinationPath = public_path('materi');
                $file->move($destinationPath, $fileName);
                $materiFile = 'materi/' . $fileName;
                Materi::create([
                    'judul' => $judul,
                    'konten' => $fileName,
                    'link' => $materiFile,
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
            'konten' => 'nullable|string',
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

        $this->updateMateriTraining(
            $validated['judul'],
            $validated['konten'],
            $id,
            $request->hasFile('materi') ? $request->file('materi') : null
        );

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan.');
    }

    private function updateMateriTraining($judul, $konten, $id, $file) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
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
                'konten' => $konten, 
            ]);
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');
                $data = Materi::findOrFail($id);
                $materiFile = $data->link;
                if ($file) { 
                    if (file_exists(public_path($materiFile))) { 
                        unlink(public_path($materiFile)
                    ); }
                    $destinationPath = public_path('materi');
                    $fileName = $judul . '.pdf';
                    $file->move($destinationPath, $fileName); 
                    $materiFile = 'materi/' . $fileName; 
                } else{
                    $fileName = $data->konten;
                    $materiFile = $data->link;
                } 

                $data->update([
                    'judul' => $judul,
                    'konten' => $fileName,
                    'link' => $materiFile,
                ]);
                Log::info('Data updated successfully');
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
        $this->deleteDataMateri($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    private function deleteDataMateri($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/materi/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $data = Materi::findOrFail($id);
                $materiFile = $data->link;
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
