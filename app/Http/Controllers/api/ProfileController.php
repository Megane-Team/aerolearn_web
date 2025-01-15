<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $d = Auth::user();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => [
                'id' => $d->id,
                'user_role' => $d->user_role,
                'nama' => $d->info->nama, 
                'email'=> $d->email, 
                'tempat_lahir' => $d->info->tempat_lahir,
                'tanggal_lahir'=> $d->info->tanggal_lahir,
                'no_telp'=> $d->info->no_telp,
            ]
        ], 200);
    }
    public function getSertif(){
        $data = Sertifikat::where('id_peserta',Auth::user()->id)->get();
        if ($data->count() > 0) {
            return response()->json([
                'statusCode' => 200,
                'message' => 'Success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Not Found',
            ], 404);
        }
    }
}
