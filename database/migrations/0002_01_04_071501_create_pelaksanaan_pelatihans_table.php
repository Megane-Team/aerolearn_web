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
        Schema::create('pelaksanaan_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelatihan')->constrained('pelatihan')->onDelete('cascade');
            $table->foreignId('id_instruktur')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('jenis_training',["mandatory", "general knowledge", "customer requested"]);

            $table->foreignId('id_ruangan')->constrained('ruangan')->onDelete('cascade');
            $table->enum('is_selesai',['selesai','belum']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_pelatihans');
    }
};
