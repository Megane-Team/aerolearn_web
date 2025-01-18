<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Alat;
use App\Models\Feedback;
use App\Models\Nilai;
use App\Models\Notifications;
use App\Models\PelaksanaanPelatihan;
use App\Models\Pelatihan;
use App\Models\PermintaanTraining;
use App\Models\PesertaPelatihan;
use App\Models\Ruangan;
use App\Models\Sertifikat;
use App\Models\TableAlat;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PelaksanaanPelatihanController extends Controller
{
    public function index()
    {
        return view('pelaksanaan.index', [
            'data' => PelaksanaanPelatihan::get(),
            'pelatihan' => Pelatihan::get(),
            'instruktur' => User::where('user_role', 'instruktur')->get(),
            'ruangan' => Ruangan::where('status_ruangan', 'tidak dipakai')->get(),
        ]);
    }
    public function tambah(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'id_pelatihan' => 'required|exists:pelatihan,id',
            'id_instruktur' => 'required|exists:users,id', // Pastikan tabel instrukturs ada
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jenis_training' => 'required|string|max:255',
            'id_ruangan' => 'required|exists:ruangan,id', // Pastikan tabel ruangans ada
            'is_selesai' => 'required',
        ]);

        $data = PelaksanaanPelatihan::create([
            'id_pelatihan' => $request->id_pelatihan,
            'id_instruktur' => $request->id_instruktur,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jenis_training' => $request->jenis_training,
            'id_ruangan' => $request->id_ruangan,
            'is_selesai' => $request->is_selesai,
        ]);
        Ruangan::where('id', $request->id_ruangan)->update([
            'status_ruangan' => 'dipakai'
        ]);
        PermintaanTraining::create([
            'id_pelaksanaanPelatihan' => $data->id,
            'status' => 'menunggu'
        ]);
        $head = User::where('user_role', 'kepala pelatihan')->first();
        Notifications::create([
            'id_peserta' => $head->id,
            'id_pelaksanaan_pelatihan' => $data->id,
            'title' => 'Memerlukan konfirmasi',
            'detail' => 'Pelaksanaan pelatihan ' . $data->pelatihan->nama . ' memerlukan konfirmasi',
            'tanggal' => now(),
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil disimpan.');
    }

    public function update($id, Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'id_pelatihan' => 'required|exists:pelatihan,id',
            'id_instruktur' => 'required|exists:users,id', // Pastikan tabel instrukturs ada
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jenis_training' => 'required|string|max:255',
            'id_ruangan' => 'required|exists:ruangan,id', // Pastikan tabel ruangans ada
            'is_selesai' => 'required',
        ]);

        // Ambil data pelaksanaan pelatihan berdasarkan ID
        $pelaksanaanPelatihan = PelaksanaanPelatihan::findOrFail($id);

        // Update data di database
        $pelaksanaanPelatihan->update([
            'id_pelatihan' => $request->id_pelatihan,
            'id_instruktur' => $request->id_instruktur,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jenis_training' => $request->jenis_training,
            'id_ruangan' => $request->id_ruangan,
            'is_selesai' => $request->is_selesai,
        ]);

        // Update status ruangan (jika ruangan diubah)
        if ($pelaksanaanPelatihan->wasChanged('id_ruangan')) {
            // Ubah status ruangan lama menjadi "kosong"
            Ruangan::where('id', $pelaksanaanPelatihan->getOriginal('id_ruangan'))->update([
                'status_ruangan' => 'tidak dipakai'
            ]);

            // Ubah status ruangan baru menjadi "dipakai"
            Ruangan::where('id', $request->id_ruangan)->update([
                'status_ruangan' => 'dipakai'
            ]);
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $data = PelaksanaanPelatihan::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
    public function peserta($id)
    {
        $data = PelaksanaanPelatihan::find($id);
        $pelatihan = Pelatihan::find($data->id_pelatihan);

        $peserta = [];
        if (Auth::user()->user_role == 'admin') {
            $peserta = User::where('user_role', 'peserta')
                ->get()
                ->map(function ($user) use ($id) {
                    // Cek apakah peserta sudah ada di table_peserta
                    $user->sudah_terdaftar = DB::table('table_peserta')
                        ->where('id_peserta', $user->id)
                        ->where('id_pelaksanaan_pelatihan', $id)
                        ->exists();

                    return $user;
                });
        }
        $absensiE = [];
        $absensiM = [];
        $nilai = [];
        $sertif = [];
        $feedback = [];
        foreach ($data->tablepeserta as $k => $v) {
            # code...
            foreach ($pelatihan->exam as $key => $value) {
                $absensiE[$k][$key] = Absensi::where('id_peserta', $v->id_peserta)->where('id_pelaksanaan_pelatihan', $id)->where('id_exam', $value->id)->first();
            }
            foreach ($pelatihan->materi as $key => $value) {
                $absensiM[$k][$key] = Absensi::where('id_peserta', $v->id_peserta)->where('id_pelaksanaan_pelatihan', $id)->where('id_materi', $value->id)->first();
            }
            $nilai[$k] = Nilai::where('id_peserta', $v->id_peserta)->where('id_pelaksanaan_pelatihan', $id)->first();
            $feedback[$k] = Feedback::where('id_user', $v->id_peserta)->where('id_pelaksanaanPelatihan', $id)->first();
            $sertif[$k] = Sertifikat::where('id_peserta', $v->id_peserta)->where('id_pelatihan', $id)->first();
        }
        return view('pelaksanaan.peserta', [
            'data' => $data,
            'peserta' => $peserta,
            'pelatihan' => $pelatihan,
            'absensiE' => $absensiE,
            'absensiM' => $absensiM,
            'nilai' => $nilai,
            'feedback' => $feedback,
            'sertif' => $sertif
        ]);
    }
    public function peserta_tambah(Request $request)
    {
        $id_pelaksanaan_pelatihan = $request->id_pelaksanaan_pelatihan; // ID Pelaksanaan Pelatihan
        $id_peserta_baru = $request->id_peserta; // ID Peserta yang dicentang
        $pelaksanaanPelatihan = PelaksanaanPelatihan::find($id_pelaksanaan_pelatihan);

        // Ambil semua peserta yang sudah terdaftar di table_peserta
        $peserta_terdaftar = DB::table('table_peserta')
            ->where('id_pelaksanaan_pelatihan', $id_pelaksanaan_pelatihan)
            ->pluck('id_peserta')
            ->toArray();

        // Cari peserta yang perlu ditambahkan (ada di input tapi belum ada di database)
        $peserta_tambah = array_diff($id_peserta_baru ?? [], $peserta_terdaftar);

        // Cari peserta yang perlu dihapus (ada di database tapi tidak ada di input)
        $peserta_hapus = array_diff($peserta_terdaftar, $id_peserta_baru ?? []);

        // Tambahkan peserta baru ke table_peserta
        foreach ($peserta_tambah as $id_peserta) {
            PesertaPelatihan::create([
                'id_peserta' => $id_peserta,
                'id_pelaksanaan_pelatihan' => $id_pelaksanaan_pelatihan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus peserta yang tidak lagi dicentang
        PesertaPelatihan::where('id_pelaksanaan_pelatihan', $id_pelaksanaan_pelatihan)
            ->whereIn('id_peserta', $peserta_hapus)
            ->delete();

        

        // Redirect atau respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
    public function peserta_generatesertif($id)
    {
        $data = PelaksanaanPelatihan::findOrFail($id);
        foreach ($data->tablepeserta as $key => $value) {
            // Cek apakah sertifikat sudah ada
            $existingSertifikat = Sertifikat::where('id_pelatihan', $data->id)
                ->where('id_peserta', $value->id_peserta)
                ->first();

            if (!$existingSertifikat) {
                Sertifikat::create([
                    'id_pelatihan' => $data->id,
                    'id_peserta' => $value->id_peserta,
                    'masa_berlaku' => now()->addYears(3)->toDateString(),
                    'sertifikasi' => $data->pelatihan->nama
                ]);
            }
        }
        return back()->with('success', 'Data berhasil disimpan.');
    }
    public function peserta_sertif($id)
    {
        $d = Sertifikat::find($id);
        $qr = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . route('pelaksanaan-peserta.sertif', $id);
        $qrCodeBase64 = base64_encode(file_get_contents($qr));
        //dd($qrCodeBase64);
        $data = [
            'name' => $d->peserta->info->nama, // Bisa diambil dari request
            'judul' => $d->pelaksanaan->pelatihan->nama,
            'masa_berlaku' => $d->masa_berlaku,
            'qrcode' => $qrCodeBase64
        ];


        $pdf = PDF::loadView('sertif', $data)->setPaper([0, 0, 1654, 2339]);
        return $pdf->download($d->pelaksanaan->pelatihan->nama . '_' . $d->peserta->info->nama . '.pdf');
    }
    public function validasi($id)
    {
        Absensi::where('id', $id)->update([
            'status_absen' => 'Validasi'
        ]);
        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
    public function alat($id)
    {
        $data = PelaksanaanPelatihan::find($id);
        $alat = Alat::get()
            ->map(function ($alat) use ($id) {
                $alat->sudah_terdaftar = DB::table('tablealat')
                    ->where('id_alat', $alat->id)
                    ->where('id_pelaksanaan_pelatihan', $id)
                    ->exists();

                return $alat;
            });
        return view('pelaksanaan.alat', [
            'data' => $data,
            'alat' => $alat
        ]);
    }
    public function alat_tambah(Request $request)
    {
        TableAlat::where('id_pelaksanaan_pelatihan', $request->id_pelaksanaan_pelatihan)->delete();
        foreach ($request->id_alat as $key => $value) {
            TableAlat::create([
                'id_alat' => $value,
                'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan
            ]);
        }
        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
    public function status($id, $t)
    {
        $data = PermintaanTraining::find($id);
        $data->status = $t == 1 ? 'terima' : 'tolak';
        $data->save();
        if ($t == 1) {
            $instruktur = User::where('user_role', 'instruktur')->first();
            $pelaksanaanPelatihan = PelaksanaanPelatihan::find($data->id_pelaksanaanPelatihan);
            $peserta = PesertaPelatihan::where('id_pelaksanaan_pelatihan',$data->id_pelaksanaanPelatihan);
            Notifications::create([
                'id_peserta' => $instruktur->id,
                'id_pelaksanaan_pelatihan' => $pelaksanaanPelatihan->id,
                'title' => 'Pelatihan diadakan',
                'detail' => 'Pelaksanaan pelatihan ' . $pelaksanaanPelatihan->pelatihan->nama . ' akan dilaksanakan pada ' . $pelaksanaanPelatihan->tanggal_mulai,
                'tanggal' => now(),
            ]);
            foreach ($peserta as $key => $value) {
                Notifications::create([
                    'id_peserta' => $value->id_peserta,
                    'id_pelaksanaan_pelatihan' => $pelaksanaanPelatihan->id,
                    'title' => 'Pelatihan diadakan',
                    'detail' => 'Pelaksanaan pelatihan ' . $pelaksanaanPelatihan->pelatihan->nama . ' akan dilaksanakan pada ' . $pelaksanaanPelatihan->tanggal_mulai,
                    'tanggal' => now(),
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }
}
