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
            'email' => 'admin@example.com',
            'nama' => 'admin',
            'password' => Hash::make('admin123'),
            'user_role' => 'admin'
        ]);
    }
}
