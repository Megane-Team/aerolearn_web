<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanPelatihan;
use App\Models\Pelatihan;
use App\Models\PermintaanTraining;
use App\Models\PesertaPelatihan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TrainingController extends Controller
{
    public function getAll(): JsonResponse
    {
        $data = PelaksanaanPelatihan::get();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
    public function getAllPelatihan(): JsonResponse
    {
        $data = Pelatihan::get();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
    public function getPelatihanDetail($id): JsonResponse
    {
        $data = Pelatihan::find($id);
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
    public function getDetail($id): JsonResponse
    {
        $data = PelaksanaanPelatihan::get();
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
    public function getTanggal(): JsonResponse
    {
        // Validasi input tanggal
        $validated = $request->validate([
            'tanggal' => 'required|date',
        ]);

        // Ambil tanggal dari request
        $tanggal = $validated['tanggal'];

        // Query data berdasarkan tanggal
        $data = PelaksanaanPelatihan::whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get();

        // Jika data kosong, kembalikan respons 401
        if ($data->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No data found for the given date',
            ], 404);
        }

        // Jika data ditemukan, kembalikan respons 200 dengan data
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
    public function getProgress($id): JsonResponse
    {
        // Ambil data peserta berdasarkan id
        $peserta = PesertaPelatihan::where('id_peserta', $id)->get();

        if ($peserta->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Peserta not found',
            ], 404);
        }

        // Ambil id_pelaksanaan_pelatihan dari peserta
        $idPelaksanaanPelatihan = $peserta->pluck('id_pelaksanaan_pelatihan');

        // Ambil data training yang diterima berdasarkan id_pelaksanaan_pelatihan
        $training = PermintaanTraining::whereIn('id_pelaksanaanPelatihan', $idPelaksanaanPelatihan)
            ->where('status', 'terima')
            ->get();

        if ($training->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No training data found',
            ], 404);
        }

        // Ambil data pelaksanaan pelatihan dengan join ke tabel terkait
        $progress = PelaksanaanPelatihan::select([
            'pelaksanaan_pelatihan.id',
            'pelaksanaan_pelatihan.tanggal_mulai',
            'pelaksanaan_pelatihan.tanggal_selesai',
            'pelaksanaan_pelatihan.jam_mulai as jamMulai',
            'pelaksanaan_pelatihan.jam_selesai as jamSelesai',
            'pelaksanaan_pelatihan.is_selesai as isSelesai',
            'pelaksanaan_pelatihan.jenis_training',
            'pelatihan.nama as nama_pelatihan',
            'pelaksanaan_pelatihan.id_pelatihan',
            'users.email as nama_instruktur',
            'ruangan.nama as ruangan',
        ])
            ->join('pelatihan', 'pelaksanaan_pelatihan.id_pelatihan', '=', 'pelatihan.id')
            ->join('users', 'pelaksanaan_pelatihan.id_instruktur', '=', 'users.id')
            ->join('ruangan', 'pelaksanaan_pelatihan.id_ruangan', '=', 'ruangan.id')
            ->whereIn('pelaksanaan_pelatihan.id', $idPelaksanaanPelatihan)
            ->get();

        // Filter data progress berdasarkan id_pelaksanaanPelatihan dari training
        $filteredProgress = $progress->filter(function ($item) use ($training) {
            return $training->contains('id_pelaksanaanPelatihan', $item->id);
        });

        if ($filteredProgress->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'No progress data found',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $filteredProgress->values(),
        ], 200);
    }
}
