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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->nullable()->constrained('karyawan')->onDelete('cascade');
            $table->foreignId('id_eksternal')->nullable()->constrained('eksternal')->onDelete('cascade');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('user_role', ['peserta', 'instruktur', 'admin', 'kepala pelatihan'])->default('peserta');
            $table->enum('user_type', ['eksternal', 'internal'])->default('internal');
            $table->string('token')->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
