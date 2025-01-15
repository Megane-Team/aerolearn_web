<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function adding(Request $request): JsonResponse
    {
        Nilai::create([
            'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan,
            'id_peserta' => $request->id_peserta ?? Auth::user()->id,
            'score' => $request->score
        ]);
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
    public function getNilai(Request $request): JsonResponse
    {
        $data = Nilai::where(
            'id_pelaksanaan_pelatihan',
            $request->id_pelaksanaan_pelatihan
        )->where('id_peserta', $request->id_peserta)->first();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
}
