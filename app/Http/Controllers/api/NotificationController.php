<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function getAll($id): JsonResponse
    {
        $data = Notifications::where('id_peserta',$id)->get();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
}
