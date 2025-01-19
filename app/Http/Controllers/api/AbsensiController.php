<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index($id): JsonResponse
    {
        // Mencari data absensi berdasarkan ID
        $data = Absensi::where('id_pelaksanaan_pelatihan', $id)->get();

        // Jika data tidak ditemukan, kembalikan respons error
        if ($data->count() == 0) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'tidak ada data di pelaksanaan pelatihan yang dipilih',
            ], 404);
        }

        // Jika data ditemukan, kembalikan respons sukses
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data,
        ], 200);
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_materi' => 'nullable|integer',
            'id_exam' => 'nullable|integer',
            'id_peserta'=> 'required|integer',
            'id_pelaksanaan_pelatihan' => 'required|integer',
        ]);

        $id_materi = $validated['id_materi'] ?? null;
        $id_exam = $validated['id_exam'] ?? null;
        $id_pelaksanaan_pelatihan = $validated['id_pelaksanaan_pelatihan'];
        $id_peserta = $validated['id_peserta'];


        // Cek apakah peserta sudah absen
        $res = Absensi::where('id_peserta', $id_peserta)
            ->where('id_pelaksanaan_pelatihan', $id_pelaksanaan_pelatihan)
            ->where(function ($query) use ($id_materi, $id_exam) {
                $query->where('id_materi', $id_materi)
                      ->orWhere('id_exam', $id_exam);
            })
            ->exists();

        if ($res) {
            return response()->json([
                'statusCode' => 401,
                'message' => 'Trainee is already absen',
            ], 401);
        }

        // Insert data absensi
        Absensi::create([
            'id_pelaksanaan_pelatihan' => $id_pelaksanaan_pelatihan,
            'id_materi' => $id_materi,
            'id_exam' => $id_exam,
            'id_peserta' => $id_peserta,
            'status_absen' => 'Belum Validasi',
            'created_at' => now(),
        ]);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
}
