<?php

namespace App\Http\Controllers;

use App\Models\Eksternal;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1); // Default ke 1 jika tidak ada `page`

        $peserta['internal'] = User::with(['internal', 'sertif'])->where('user_role', 'peserta')->where('user_type', 'internal')->orderBy('email', 'desc') // Optional
            ->paginate(10);
        $peserta['eksternal'] = User::with(['eksternal', 'sertif'])->where('user_role', 'peserta')->where('user_type', 'eksternal')->orderBy('email', 'desc') // Optional
            ->paginate(10);
        //dd($peserta['eksternal'][0]->eksternal);
        return view('peserta.index', ['data' => $peserta,'page' => $page]);
    }
    public function tambah($i, Request $request)
    {
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
            $karyawan = Karyawan::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'unit_org' => $request->unit_org,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'posisi' => $request->posisi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'tmt' => $request->tmt,
                'jobcode' => $request->jobcode,
            ]);
            User::create([
                'id_karyawan' => $karyawan->id,
                'email' => $karyawan->email,
                'nama' => $karyawan->nama,
                'password' => Hash::make($request->password),
                'user_type' => 'internal',
                'user_role' => 'peserta'
            ]);
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
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
            $eksternal = Eksternal::create([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
            ]);
            User::create([
                'id_eksternal' => $eksternal->id,
                'email' => $eksternal->email,
                'password' => Hash::make($request->password),
                'user_type' => 'eksternal',
                'user_role' => 'peserta'
            ]);
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
        }
    }
    public function update($i, $id, Request $request)
    {
        if ($i == 1) {
            $user = User::findOrFail($id);
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->internal->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'unit_org' => $request->unit_org,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'posisi' => $request->posisi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'tmt' => $request->tmt,
                'jobcode' => $request->jobcode,
            ]);
            $user->save();
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
        } else {
            $user = User::findOrFail($id);
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->eksternal->update([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
            ]);
            $user->save();
            return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil disimpan.');
        }
    }
    public function hapus($i, $id)
    {
        if ($i == 1) {
            $user = User::findOrFail($id);
            $user->internal->delete();
            $user->delete();
        } else {
            $user = User::findOrFail($id);
            $user->eksternal->delete();
            $user->delete();
        }
        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
