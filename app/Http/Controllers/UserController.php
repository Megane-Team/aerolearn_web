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

        $response = $this->postUser(
            $request,
        );

        if($response){
            User::create([
                'nama' => $validated['nama'],
                'id_eksternal' => null,
                'id_karyawan' => null,
                'email' => $validated['email'],
                'password' => Hash::make($request->password),
                'user_type' => 'internal',
                'user_role' => $validated['user_role'],
            ]);
            return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
        }else{
            return redirect()->route('user.index')->with('error', 'Data peserta gagal disimpan.');
        }
    }

    private function postUser(Request $request) { 
        try { 
            $token = session('api_token');
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/user/registrasi', [ 
                'nama' => $request->nama, 
                'id_eksternal' => null, 
                'id_karyawan' => null,
                'user_type' => "internal", 
                'user_role' => $request->user_role, 
                'email' => $request->email, 
                'password' => $request->password, 
            ]); 
                    
            if ($response->successful()) {
                
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
        $berhasil = $this->updateDataUser(
            $id,
            $request
        );

        if( !$berhasil ){
            return redirect()->route('user.index')->with('error', 'Data peserta gagal disimpan.');
        }else{
            return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
        }
    }
    
    private function updateDataUser($id, Request $request) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/user/update/'.$id, [ 
                'nama' => $request->nama,
                'email' => $request->email,
                'user_role' => $request->user_role,
                'password' => $request->password,
            ]); 
    
            if ($response->successful()) { 
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
        $berhasil = $this->deleteDataUser($id);
        if( !$berhasil){
            return redirect()->route('user.index')->with('error', 'Data peserta gagal dihapus.');
        }else{
            return redirect()->route('user.index')->with('success', 'Data peserta berhasil dihapus.');
        }
    }

    private function deleteDataUser($id) { 
        try { 
            $url = config('app.api_base_url');
            $token = session('api_token');
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/user/delete/' . $id,);
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
