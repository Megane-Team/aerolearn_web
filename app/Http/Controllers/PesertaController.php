<?php

namespace App\Http\Controllers;

use App\Models\Eksternal;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

    class PesertaController extends Controller
    {
        public function index()
        {
            $peserta['internal'] = User::with('internal')->where('user_role', 'peserta')->where('user_type', 'internal')->get();
            $peserta['eksternal'] = User::with('eksternal')->where('user_role', 'peserta')->where('user_type', 'eksternal')->get();
            return view('peserta.index', ['data' => $peserta]);
        }
        public function tambah($i, Request $request)
        {
            $berhasil = false;
            if ($i == 1) {
                $validated = $request->validate([
                    'nik' => 'required|integer',
                    'nama' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date',
                    'tempat_lahir' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'unit_org' => 'required|string|max:255',
                    'alamat' => 'required|string',
                    'status' => 'nullable|string|max:255',
                    'posisi' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'no_telp' => 'required|string|max:20',
                    'tmt' => 'nullable|date',
                    'jobcode' => 'nullable|string|max:255',
                    'password' => 'required|string|min:8',
                ]);
                $berhasil = $this->postDataInternal(
                    $request->nik,
                    $request->nama,
                    $request->tanggal_lahir,
                    $request->tempat_lahir,
                    $request->jenis_kelamin,
                    $request->unit_org,
                    $request->alamat,
                    $request->status,
                    $request->posisi,
                    $request->email,
                    $request->no_telp,
                    $request->tmt,
                    $request->jobcode,
                    $request->password,
                );
            } else {
                $validated = $request->validate([
                    'nama' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date',
                    'tempat_lahir' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'alamat' => 'required|string',
                    'email' => 'required|email|max:255|unique:users,email',
                    'no_telp' => 'required|string|max:20',
                    'password' => 'required|string|min:8',
                ]);

                Log::info('masuk ke sini');

                $berhasil  = $this->postDataEksternal(
                    $request->nama,
                    $request->email,
                    $request->alamat,
                    $request->no_telp,
                    $request->tempat_lahir,
                    $request->tanggal_lahir,
                    $request->jenis_kelamin,
                    $request->password
                );
            }
            if($berhasil){
                return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
            }else{
                return redirect()->route('peserta.index')->with('error', 'Data peserta gagal disimpan.');
            }
        }
        private function postDataEksternal($nama, $email, $alamat, $no_telp, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $password) { 
            try { 
                Log::info('halo');
                $url = config('app.api_base_url');
                $token = session('api_token');
                Log::info('Token from session: ' . $token);
        
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ])->post($url . '/eksternal/+', [ 
                    'nama' => $nama, 
                    'email' => $email, 
                    'alamat' => $alamat, 
                    'no_telp' => $no_telp, 
                    'tempat_lahir' => $tempat_lahir, 
                    'tanggal_lahir' => $tanggal_lahir, 
                    'jenis_kelamin' => $jenis_kelamin,
                ]); 
        
                Log::info('Response: ' . $response->body());
                if ($response->successful()) { 
                    Log::info('success');
                    $eksternal = Eksternal::create([
                        'nama' => $nama,
                        'tanggal_lahir' => $tanggal_lahir,
                        'tempat_lahir' => $tempat_lahir,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'email' => $email,
                        'no_telp' => $no_telp,
                    ]);
        
                    Log::info('Calling postUser function');
                    $this->postUser(
                        $email,
                        $password,
                        $eksternal->id,
                        null,
                        'eksternal',
                        'peserta',
                        $token
                    );

                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) { 
                return false;
            } 
        }

        private function postDataInternal($nik, $nama, $tanggal_lahir, $tempat_lahir, $jenis_kelamin, $unit_org, $alamat, $status, $posisi, $email, $no_telp, $tmt, $jobcode, $password) { 
            try { 
                Log::info('halo');
                $url = config('app.api_base_url');
                $token = session('api_token');
                Log::info('Token from session: ' . $token);
        
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ])->post($url . '/karyawan/+', [ 
                    'nik' => (int)$nik, 
                    'nama' => $nama, 
                    'tanggal_lahir' => $tanggal_lahir, 
                    'tempat_lahir' => $tempat_lahir, 
                    'jenis_kelamin' => $jenis_kelamin, 
                    'unit_org' => $unit_org, 
                    'alamat' => $alamat, 
                    'status' => $status, 
                    'posisi' => $posisi, 
                    'email' => $email, 
                    'no_telp' => $no_telp, 
                    'tmt' => $tmt, 
                    'job_code' => $jobcode,
                ]); 
        
                Log::info('Response: ' . $response->body());
                if ($response->successful()) { 
                    Log::info('success');
                    $karyawan = Karyawan::create([
                        'nik' => $nik,
                        'nama' => $nama,
                        'tanggal_lahir' => $tanggal_lahir,
                        'tempat_lahir' => $tempat_lahir,
                        'jenis_kelamin' => $jenis_kelamin,
                        'unit_org' => $unit_org,
                        'alamat' => $alamat,
                        'status' => $status,
                        'posisi' => $posisi,
                        'email' => $email,
                        'no_telp' => $no_telp,
                        'tmt' => $tmt,
                        'jobcode' => $jobcode,
                    ]);
        
                    Log::info('Calling postUser function');
                    $this->postUser(
                        $email,
                        $password,
                        null,
                        $karyawan->id,
                        'internal',
                        'peserta',
                        $token
                    );

                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) { 
                return false;
            } 
        }
        

        private function postUser($email, $password, $id_eksternal, $id_karyawan, $userType, $userRole, $token) { 
        try { 
            Log::info('Token in postUser: ' . $token);
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/user/registrasi', [ 
                'id_eksternal' => $id_eksternal, 
                'id_karyawan' => $id_karyawan,
                'user_type' => $userType, 
                'user_role' => $userRole, 
                'email' => $email, 
                'password' => $password, 
            ]); 
                    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) {
                User::create([
                    'id_eksternal' => $id_eksternal,
                    'id_karyawan' => $id_karyawan,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'user_type' => $userType,
                    'user_role' => 'peserta'
                ]);
                    
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }



    public function update($i, $id, Request $request)
    {
        if ($i == 1) {
            $this->updateDataInternal(
                $id,
                $request->nik,
                $request->nama,
                $request->tanggal_lahir,
                $request->tempat_lahir,
                $request->jenis_kelamin,
                $request->unit_org,
                $request->alamat,
                $request->status,
                $request->posisi,
                $request->email,
                $request->no_telp,
                $request->tmt,
                $request->jobcode,
                $request->password
            );
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
        } else {
            $this->updateDataEksternal(
                $id,
                $request->nama,
                $request->email,
                $request->alamat,
                $request->no_telp,
                $request->tempat_lahir,
                $request->tanggal_lahir,
                $request->jenis_kelamin,
                $request->password
            );
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
        }
    }

    private function updateDataEksternal($id, $nama, $email, $alamat, $no_telp, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $password) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/eksternal/update/' . $id, [ 
                'nama' => $nama, 
                'email' => $email, 
                'alamat' => $alamat, 
                'no_telp' => $no_telp, 
                'tempat_lahir' => $tempat_lahir, 
                'tanggal_lahir' => $tanggal_lahir, 
                'jenis_kelamin' => $jenis_kelamin,
                'password' => $password,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $user = User::findOrFail($id);
                $user->email = $email;
                if ($password) {
                    $user->password = Hash::make($password);
                }
                $user->eksternal->update([
                    'nama' => $nama,
                    'tanggal_lahir' => $tanggal_lahir,
                    'tempat_lahir' => $tempat_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'email' => $email,
                    'no_telp' => $no_telp,
                ]);
                $user->save();

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }

    private function updateDataInternal($id, $nik, $nama, $tanggal_lahir, $tempat_lahir, $jenis_kelamin, $unit_org, $alamat, $status, $posisi, $email, $no_telp, $tmt, $jobcode, $password) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/karyawan/update/' . $id, [ 
                'nik' => (int)$nik, 
                'nama' => $nama, 
                'tanggal_lahir' => $tanggal_lahir, 
                'tempat_lahir' => $tempat_lahir, 
                'jenis_kelamin' => $jenis_kelamin, 
                'unit_org' => $unit_org, 
                'alamat' => $alamat, 
                'status' => $status, 
                'posisi' => $posisi, 
                'email' => $email, 
                'no_telp' => $no_telp, 
                'tmt' => $tmt, 
                'job_code' => $jobcode,
                'password' => $password,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $user = User::findOrFail($id);
                $user->email = $email;
                if ($password) {
                    $user->password = Hash::make($password);
                }
                $user->internal->update([
                    'nik' => $nik,
                    'nama' => $nama,
                    'tanggal_lahir' => $tanggal_lahir,
                    'tempat_lahir' => $tempat_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'unit_org' => $unit_org,
                    'alamat' => $alamat,
                    'status' => $status,
                    'posisi' => $posisi,
                    'email' => $email,
                    'no_telp' => $no_telp,
                    'tmt' => $tmt,
                    'jobcode' => $jobcode,
                ]);
                $user->save();

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
    public function hapus($i, $id)
    {
        if ($i == 1) {
            $this->deleteDataInternal($id);
        } else {
            $this->deleteDataEksternal($id);
        }
        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
    private function deleteDataInternal($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/karyawan/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $user = User::findOrFail($id);
                $user->internal->delete();
                $user->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }

    private function deleteDataEksternal($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/eksternal/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $user = User::findOrFail($id);
                $user->eksternal->delete();
                $user->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}


