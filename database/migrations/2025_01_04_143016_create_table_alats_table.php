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
        Schema::create('tableAlat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alat')->constrained('alat')->onDelete('cascade');
            $table->foreignId('id_pelaksanaan_pelatihan')->constrained('pelaksanaan_pelatihan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_alats');
    }
};
