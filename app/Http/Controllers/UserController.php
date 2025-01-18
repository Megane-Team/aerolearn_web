<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function index()
    {
        $peserta = User::where('user_role','!=' ,'peserta')->get();
        return view('user.index', ['data' => $peserta]);
    }
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'user_role' => 'required',
        ]);

        $this->postUser(
            $request->nama,
            $request->email,
            $request->password,
            null,
            null,
            'internal',
            $request->user_role,
        );
        
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
    }

    private function postUser($nama, $email, $password, $id_eksternal, $id_karyawan, $userType, $userRole) { 
        try { 
            $token = session('api_token');
            Log::info('Token in postUser: ' . $token);
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/user/registrasi', [ 
                'nama' => $nama, 
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
                    'email' => $email,
                    'nama' => $nama,
                    'password' => Hash::make($password),
                    'user_type' => 'internal',
                    'user_role' => $userRole,
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
        // $user = User::findOrFail($id);
        // $user->email = $request->email;
        // $user->nama = $request->nama;
        // $user->user_role = $request->user_role;
        // if ($request->password) {
        //     $user->password = Hash::make($request->password);
        // }
        // $user->save();
        $this->updateDataUser(
            $id,
            $request
        );
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    
    private function updateDataUser($id, Request $request) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/user/update/'.$id, [ 
                'nama' => $request->nama,
                'email' => $request->email,
                'user_role' => $request->user_role,
                'password' => $request->password,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');
                $user = User::findOrFail($id);
                $user->email = $request->email;
                $user->nama = $request->nama;
                $user->user_role = $request->user_role;
                if ($request->password) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

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
        // $user = User::findOrFail($id);
        // $user->delete();
        $this->deleteDataUser($id);
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil dihapus.');
    }

    private function deleteDataUser($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/user/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $user = User::findOrFail($id);
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
