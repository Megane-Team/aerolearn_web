<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Notifications;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function tambah(Request $request): JsonResponse
    {
        Notifications::create([
            'id_peserta' => $request->id_peserta,
            'title' => $request->title,
            'detail' => $request->detail,
            'tanggal' => $request->tanggal,
            'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan,
        ]);
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
}
