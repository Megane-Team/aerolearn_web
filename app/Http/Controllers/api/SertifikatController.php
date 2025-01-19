<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    public function sertifikatAdd(Request $request): JsonResponse
    {
        Sertifikat::create([
            'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan,
            'id_peserta' => $request->id_peserta,
            'masa_berlaku' => $request->masa_berlaku,
            'sertifikasi' => $request->sertifikasi,
            'tanggal' => $request->tanggal,
        ]);
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
}
