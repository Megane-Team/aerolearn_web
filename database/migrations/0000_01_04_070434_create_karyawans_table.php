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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin',["L","P"]);
            $table->string('unit_org');
            $table->string('alamat');
            $table->string('status')->nullable();
            $table->string('posisi');
            $table->string('email');
            $table->string('no_telp');
            $table->string('tmt')->nullable();
            $table->string('jobcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
