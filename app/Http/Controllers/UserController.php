<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        User::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'user_type' => 'internal',
            'user_role' => $request->user_role
        ]);
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->nama = $request->nama;
        $user->user_role = $request->user_role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil disimpan.');
    }
    public function hapus($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
