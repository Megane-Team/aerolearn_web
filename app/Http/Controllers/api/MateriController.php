<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MateriController extends Controller
{
    public function getAll($id): JsonResponse
    {
        $data = Materi::where('id_pelatihan',$id)->get();
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
