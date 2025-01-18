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

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/absensi/{id}', [AbsensiController::class, 'index']);
    Route::post('/absensi/+', [AbsensiController::class, 'store']);

    Route::get('/absensi/materi/{id}/{idp}', [AbsensiController::class, 'getAbsensiMateri']);
    Route::get('/absensi/exam/{id}/{idp}', [AbsensiController::class, 'getAbsensiExam']);

    Route::post('/exam/question/jawaban/{id?}', [ExamController::class, 'menjawab']);
    Route::get('/exam/question/jawaban/{id}', [ExamController::class, 'getJawaban']);
    Route::get('/exam/{id}', [ExamController::class, 'index']);
    Route::get('/exam/question/{id}', [ExamController::class, 'getQuestion']);
    Route::get('/exam/question/option/{id}', [ExamController::class, 'getOption']);
    Route::get('/exam/question/jawabanbenar/{id}', [ExamController::class, 'getJawabanBenar']);

    Route::post('/nilai/+', [NilaiController::class, 'adding']);
    Route::get('/nilai/{id}/{id_pelaksanaan}', [NilaiController::class, 'getNilai']);

    Route::get('/profile', [ProfileController::class, 'index']);

    Route::get('/pelaksanaan', [TrainingController::class, 'getAll']);
    Route::get('/pelatihan', [TrainingController::class, 'getAllPelatihan']);
    Route::get('/pelatihan/{id}', [TrainingController::class, 'getPelatihanDetail']);
    Route::get('/peserta/progress/{id}', [TrainingController::class, 'getProgress']);

    Route::get('/notification/{id}', [NotificationController::class, 'getAll']);

    Route::get('/materi/{id}', [MateriController::class, 'getAll']);
    Route::post('/feedback/{id}',[ExamController::class,'feedback']);

    Route::get('/sertif', [ProfileController::class, 'getSertif']);
});
