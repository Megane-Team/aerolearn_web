<?php

use App\Http\Controllers\api\LoginController as ApiLoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PelaksanaanPelatihanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Auth::routes(['register' => false]);
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\AdminController::class, 'home'])->name('home');
    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::post('/peserta-tambah/{type}', [PesertaController::class, 'tambah'])->name('peserta.tambah');
    Route::post('/peserta-update/{type}/{id}', [PesertaController::class, 'update'])->name('peserta.update');
    Route::get('/peserta-hapus/{type}/{id}', [PesertaController::class, 'hapus'])->name('peserta.hapus');

    Route::get('pelatihan',[PelatihanController::class,'index'])->name('pelatihan.index');
    Route::post('pelatihan-tambah',[PelatihanController::class,'tambah'])->name('pelatihan.tambah');
    Route::post('pelatihan-update/{id}',[PelatihanController::class,'update'])->name('pelatihan.update');
    Route::get('pelatihan-hapus/{id}',[PelatihanController::class,'hapus'])->name('pelatihan.hapus');

    Route::get('pelatihan-materi/{id}',[MateriController::class,'index'])->name('materi.index');
    Route::post('materi-tambah',[MateriController::class,'tambah'])->name('materi.tambah');
    Route::post('materi-update/{id}',[MateriController::class,'update'])->name('materi.update');
    Route::get('materi-hapus/{id}',[MateriController::class,'hapus'])->name('materi.hapus');

    Route::get('pelatihan-exam/{id}',[ExamController::class,'index'])->name('exam.index');
    Route::post('exam-tambah',[ExamController::class,'tambah'])->name('exam.tambah');
    Route::post('exam-update/{id}',[ExamController::class,'update'])->name('exam.update');
    Route::get('exam-hapus/{id}',[ExamController::class,'hapus'])->name('exam.hapus');

    Route::get('exam-question/{id}', [QuestionController::class, 'index'])->name('question.index');
    Route::post('question-tambah', [QuestionController::class, 'tambah'])->name('question.tambah');
    Route::get('question-hapus/{id}', [QuestionController::class, 'hapus'])->name('question.hapus');

    Route::get('pelaksanaan', [PelaksanaanPelatihanController::class, 'index'])->name('pelaksanaan.index');
    Route::post('pelaksanaan-tambah', [PelaksanaanPelatihanController::class, 'tambah'])->name('pelaksanaan.tambah');
    Route::post('pelaksanaan-update/{id}', [PelaksanaanPelatihanController::class, 'update'])->name('pelaksanaan.update');
    Route::get('pelaksanaan-hapus/{id}', [PelaksanaanPelatihanController::class, 'hapus'])->name('pelaksanaan.hapus');
    Route::get('pelaksanaan-status/{id}/{t}', [PelaksanaanPelatihanController::class, 'status'])->name('pelaksanaan.status');

    Route::get('pelaksanaan-peserta/{id}', [PelaksanaanPelatihanController::class, 'peserta'])->name('pelaksanaan-peserta.index');
    Route::get('pelaksanaan-peserta-absensi-validasi/{id}', [PelaksanaanPelatihanController::class, 'validasi'])->name('pelaksanaan-peserta.validasi');
    Route::post('pelaksanaan-peserta-tambah', [PelaksanaanPelatihanController::class, 'peserta_tambah'])->name('pelaksanaan-peserta.tambah');
    Route::get('pelaksanaan-peserta-sertif/{id}', [PelaksanaanPelatihanController::class, 'peserta_sertif'])->name('pelaksanaan-peserta.sertif');
    Route::get('pelaksanaan-peserta-generatesertif/{id}', [PelaksanaanPelatihanController::class, 'peserta_generatesertif'])->name('pelaksanaan-peserta.generatesertif');

    Route::get('pelaksanaan-alat/{id}', [PelaksanaanPelatihanController::class, 'alat'])->name('pelaksanaan-alat.index');
    Route::post('pelaksanaan-alat-tambah', [PelaksanaanPelatihanController::class, 'alat_tambah'])->name('pelaksanaan-alat.tambah');


    Route::get('import', function () {
        return view('import');
    })->name('import');
    Route::post('import', function (Request $request) {
        $data = json_decode($request->input('json_data'), true);
        foreach ($data as $row) {
            $karyawan = Karyawan::create([
                'nik'       => $row[0] ?? null,
                'nama'      => $row[1] ?? null,
                'tanggal_lahir'   => $row[2] ?? null,
                'tmt'       => $row[3] ?? null,
                'tempat_lahir'  => $row[4] ?? null,
                'jenis_kelamin'        => $row[5] ?? null,
                'unit_org'        => $row[6] ?? null,
                'jobcode'  => $row[7] ?? null,
                'status' => 'sehat',
                'alamat' => $row[4] ?? null,
                'posisi' => 'tidak diketahui',
                'email' =>  $row[0].'@gmail.com',
                'no_telp' => '08999'
            ]);
            User::create([
                'id_karyawan' => $karyawan->id,
                'email' => $karyawan->email,
                'nama' => $karyawan->nama,
                'password' => Hash::make('password'),
                'user_type' => 'internal',
                'user_role' => 'peserta'
            ]);
        }

        return redirect()->route('import')->with('success', 'Data berhasil diimpor!');

    });
});
