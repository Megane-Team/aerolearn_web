<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Eksternal;
use App\Models\Karyawan;
use App\Models\Ruangan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            'email' => 'admin@gmail.com',
            'nama' => 'admin',
            'password' => Hash::make('password'),
            'user_role' => 'admin'
        ]);
        User::create([
            'email' => 'kepala@gmail.com',
            'nama' => 'kepala',
            'password' => Hash::make('password'),
            'user_role' => 'kepala pelatihan'
        ]);
        User::create([
            'email' => 'instruktur@gmail.com',
            'nama' => 'instruktur',
            'password' => Hash::make('password'),
            'user_role' => 'instruktur'
        ]);
        $k = Karyawan::create([
            'nik' => 123,
            'nama' => 'peserta internal',
            'tanggal_lahir' => date(now()),
            'tempat_lahir' => 'Surabaya',
            'jenis_kelamin' => 'L',
            'unit_org' => 1,
            'alamat' => 'surabaya',
            'status' => 'menikah',
            'posisi' => 'kasir',
            'email' => 'pesertainter@gmail.com',
            'no_telp' => '0987654',
            'tmt' => '12',
            'jobcode' => 'abc'
        ]);
        User::create([
            'id_karyawan' => $k->id,
            'email' => 'pesertainter@gmail.com',
            'nama' => $k->nama,
            'password' => Hash::make('password'),
            'user_role' => 'peserta'
        ]);

        $e = Eksternal::create([
            'nama' => 'peserta eksternal',
            'tanggal_lahir' => date(now()),
            'tempat_lahir' => 'Surabaya',
            'jenis_kelamin' => 'L',
            'alamat' => 'surabaya',
            'email' => 'pesertaeksternal@gmail.com',
            'no_telp' => '0987654',
        ]);
        User::create([
            'id_eksternal' => $e->id,
            'email' => 'pesertaeksternal@gmail.com',
            'nama' => $e->nama,
            'password' => Hash::make('password'),
            'user_role' => 'peserta',
            'user_type' => 'eksternal'
        ]);
        Ruangan::create([
            'nama' => 'Ruangan 1',
            'status_ruangan' => 'tidak dipakai'
        ]);
        Ruangan::create([
            'nama' => 'Ruangan 2',
            'status_ruangan' => 'tidak dipakai'
        ]);
        Ruangan::create([
            'nama' => 'Ruangan 3',
            'status_ruangan' => 'tidak dipakai'
        ]);
        Ruangan::create([
            'nama' => 'Ruangan 4',
            'status_ruangan' => 'tidak dipakai'
        ]);
        Ruangan::create([
            'nama' => 'Ruangan 5',
            'status_ruangan' => 'tidak dipakai'
        ]);
        Alat::create([
            'nama' => 'Alat 1',
        ]);
        Alat::create([
            'nama' => 'Alat 2',
        ]);
        Alat::create([
            'nama' => 'Alat 3',
        ]);
        Alat::create([
            'nama' => 'Alat 4',
        ]);
        Alat::create([
            'nama' => 'Alat 5',
        ]);
    }
}
