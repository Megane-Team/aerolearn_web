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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jawaban_benar')->constrained('jawaban_benar')->onDelete('cascade');
            $table->foreignId('id_pelaksanaan_pelatihan')->constrained('pelaksanaan_pelatihan')->onDelete('cascade');
            $table->foreignId('id_opsi_jawaban')->constrained('opsi_jawaban')->onDelete('cascade');
            $table->foreignId('id_peserta')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_question')->constrained('question')->onDelete('cascade');
            $table->enum('is_benar',['benar','salah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_kuis');
    }
};
