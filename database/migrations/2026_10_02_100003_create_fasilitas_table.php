<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['pembelajaran', 'pendukung'])->default('pembelajaran');
            $table->text('deskripsi');
            $table->string('jumlah')->nullable();
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
