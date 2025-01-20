<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PelaksanaanPelatihanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Models\Karyawan;
use App\Models\PelaksanaanPelatihan;
use App\Models\Pelatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Auth::routes(['register' => false]);
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\AdminController::class, 'home'])->name('home');
    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::post('/peserta-tambah/{type}', [PesertaController::class, 'tambah'])->name('peserta.tambah');
    Route::post('/peserta-update/{type}/{id}', [PesertaController::class, 'update'])->name('peserta.update');
    Route::get('/peserta-hapus/{type}/{id}', [PesertaController::class, 'hapus'])->name('peserta.hapus');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user-tambah', [UserController::class, 'tambah'])->name('user.tambah');
    Route::post('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user-hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');

    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    Route::post('/alat-tambah', [AlatController::class, 'tambah'])->name('alat.tambah');
    Route::post('/alat-update/{id}', [AlatController::class, 'update'])->name('alat.update');
    Route::get('/alat-hapus/{id}', [AlatController::class, 'hapus'])->name('alat.hapus');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/ruangan-tambah', [RuanganController::class, 'tambah'])->name('ruangan.tambah');
    Route::post('/ruangan-update/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::get('/ruangan-hapus/{id}', [RuanganController::class, 'hapus'])->name('ruangan.hapus');

    Route::get('pelatihan', [PelatihanController::class, 'index'])->name('pelatihan.index');
    Route::post('pelatihan-tambah', [PelatihanController::class, 'tambah'])->name('pelatihan.tambah');
    Route::post('pelatihan-update/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');
    Route::get('pelatihan-hapus/{id}', [PelatihanController::class, 'hapus'])->name('pelatihan.hapus');

    Route::get('pelatihan-materi/{id}', [MateriController::class, 'index'])->name('materi.index');
    Route::post('materi-tambah', [MateriController::class, 'tambah'])->name('materi.tambah');
    Route::post('materi-update/{id}', [MateriController::class, 'update'])->name('materi.update');
    Route::get('materi-hapus/{id}', [MateriController::class, 'hapus'])->name('materi.hapus');

    Route::get('pelatihan-exam/{id}', [ExamController::class, 'index'])->name('exam.index');
    Route::post('exam-tambah', [ExamController::class, 'tambah'])->name('exam.tambah');
    Route::post('exam-update/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::get('exam-hapus/{id}', [ExamController::class, 'hapus'])->name('exam.hapus');

    Route::get('exam-question/{id}', [QuestionController::class, 'index'])->name('question.index');
    Route::post('question-tambah', [QuestionController::class, 'tambah'])->name('question.tambah');
    Route::get('question-hapus/{id}', [QuestionController::class, 'hapus'])->name('question.hapus');

    Route::get('pelaksanaan', [PelaksanaanPelatihanController::class, 'index'])->name('pelaksanaan.index');
    Route::post('pelaksanaan-tambah', [PelaksanaanPelatihanController::class, 'tambah'])->name('pelaksanaan.tambah');
    Route::post('pelaksanaan-update/{id}', [PelaksanaanPelatihanController::class, 'update'])->name('pelaksanaan.update');
    Route::get('pelaksanaan-hapus/{id}', [PelaksanaanPelatihanController::class, 'hapus'])->name('pelaksanaan.hapus');
    Route::get('pelaksanaan-status/{id}/{t}', [PelaksanaanPelatihanController::class, 'status'])->name('pelaksanaan.status');
    Route::get('pelaksanaan-selesai/{id}', [PelaksanaanPelatihanController::class, 'selesai'])->name('pelaksanaan.selesai');

    Route::get('pelaksanaan-peserta/{id}', [PelaksanaanPelatihanController::class, 'peserta'])->name('pelaksanaan-peserta.index');
    Route::get('pelaksanaan-peserta-absensi-validasi/{id}', [PelaksanaanPelatihanController::class, 'validasi'])->name('pelaksanaan-peserta.validasi');
    Route::post('pelaksanaan-peserta-tambah', [PelaksanaanPelatihanController::class, 'peserta_tambah'])->name('pelaksanaan-peserta.tambah');
    Route::get('pelaksanaan-peserta-sertif/{id}', [PelaksanaanPelatihanController::class, 'peserta_sertif'])->name('pelaksanaan-peserta.sertif');
    Route::get('pelaksanaan-peserta-generatesertif/{id}', [PelaksanaanPelatihanController::class, 'peserta_generatesertif'])->name('pelaksanaan-peserta.generatesertif');

    Route::get('pelaksanaan-alat/{id}', [PelaksanaanPelatihanController::class, 'alat'])->name('pelaksanaan-alat.index');
    Route::post('pelaksanaan-alat-tambah', [PelaksanaanPelatihanController::class, 'alat_tambah'])->name('pelaksanaan-alat.tambah');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback-tambah', [FeedbackController::class, 'tambah'])->name('feedback.tambah');
    Route::post('/feedback-update/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::get('/feedback-hapus/{id}', [FeedbackController::class, 'hapus'])->name('feedback.hapus');


    Route::get('/feedback/{id_user}/{id_pelaksanaan_pelatihan}', [PelaksanaanPelatihanController::class, 'feedbackUser'])->name('pelaksanaan.feedbackUser');

    Route::get('import', function () {
        return view('import');
    })->name('import');
    Route::post('import', function (Request $request) {
        $data = json_decode($request->input('json_data'), true);
        foreach ($data as $row) {

        $url = config('app.api_base_url');
        $token = session('api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ])->post($url . '/karyawan/+', [ 
            'nik'       => $row[0] ?? null,
            'nama'      => $row[1] ?? null,
            'tanggal_lahir'   => $row[2] ?? null,
            'tmt'       => $row[3] ?? null,
            'tempat_lahir'  => $row[4] ?? null,
            'jenis_kelamin'        => $row[5] ?? null,
            'unit_org'        => $row[6] ?? null,
            'job_code'  => $row[7] ?? null,
            'status' => 'tidak diketahui',
            'alamat' => $row[4] ?? null,
            'posisi' => 'tidak diketahui',
            'email' =>  $row[0].'@gmail.com',
            'no_telp' => 'tidak ada'
        ]); 

        if ($response->successful()) { 
            $karyawan = Karyawan::create([
                'nik'       => (int) $row[0] ?? null,
                'nama'      => $row[1] ?? null,
                'tanggal_lahir'   => $row[2] ?? null,
                'tmt'       => $row[3] ?? null,
                'tempat_lahir'  => $row[4] ?? null,
                'jenis_kelamin'        => $row[5] ?? null,
                'unit_org'        => $row[6] ?? null,
                'jobcode'  => $row[7] ?? null,
                'status' => 'tidak diketahui',
                'alamat' => $row[4] ?? null,
                'posisi' => 'tidak diketahui',
                'email' =>  $row[0].'@gmail.com',
                'no_telp' => 'tidak ada'
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/user/registrasi', [ 
                'id_eksternal' => null, 
                'id_karyawan' => $karyawan->id,
                'user_type' => 'internal', 
                'user_role' => 'peserta', 
                'email' => $karyawan->email, 
                'password' => 'password', 
                'nama' => null,
            ]); 

            if($response->successful()){
                User::create([
                    'id_karyawan' => $karyawan->id,
                    'email' => $karyawan->email,
                    'nama' => $karyawan->nama,
                    'password' => Hash::make('password'),
                    'user_type' => 'internal',
                    'user_role' => 'peserta'
                ]);
            }

        }
    }

        return redirect()->route('import')->with('success', 'Data berhasil diimpor!');

    });
});