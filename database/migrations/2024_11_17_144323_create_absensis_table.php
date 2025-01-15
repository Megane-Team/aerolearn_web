<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peserta')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_pelaksanaan_pelatihan')->constrained('pelaksanaan_pelatihan')->onDelete('cascade');
            $table->foreignId('id_exam')->nullable()->constrained('exam')->onDelete('cascade');
            $table->foreignId('id_materi')->nullable()->constrained('materi')->onDelete('cascade');
            $table->enum('status_absen', ['Validasi', 'Belum Validasi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
