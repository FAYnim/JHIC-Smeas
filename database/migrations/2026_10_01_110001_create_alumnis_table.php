<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();
            $table->string('nama');
            $table->string('jurusan');
            $table->integer('tahun_lulus');
            $table->integer('angkatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
