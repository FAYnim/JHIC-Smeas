<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracer_mitra_alumnus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah_alumni');
            $table->string('catatan')->nullable();
            $table->string('warna');
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracer_mitra_alumnus');
    }
};
