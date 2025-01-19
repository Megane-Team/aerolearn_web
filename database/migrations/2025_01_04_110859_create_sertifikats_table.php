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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->string('sertifikasi');
            $table->date('masa_berlaku');
            $table->date('tanggal');
            $table->foreignId('id_peserta')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_pelaksanaan_pelatihan')->constrained('pelaksanaan_pelatihan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
