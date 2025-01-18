<?php

use App\Http\Controllers\api\AbsensiController;
use App\Http\Controllers\api\ExamController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\MateriController;
use App\Http\Controllers\api\NilaiController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\TrainingController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/absensi/+', [AbsensiController::class, 'store']);
    Route::post('/exam/question/jawaban/{id?}', [ExamController::class, 'menjawab']);
    Route::post('/nilai/+', [NilaiController::class, 'adding']);
    Route::post('/feedback/{id}',[ExamController::class,'feedback']);
});
