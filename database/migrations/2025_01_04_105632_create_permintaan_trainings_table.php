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
        Schema::create('permintaanTraining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelaksanaanPelatihan')->constrained('pelaksanaan_pelatihan')->onDelete('cascade');
            $table->enum('status',['terima', 'menunggu', 'tolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_trainings');
    }
};
