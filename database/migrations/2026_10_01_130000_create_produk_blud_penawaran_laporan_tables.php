<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_blud_penawarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_blud_id')->constrained('produk_bluds')->cascadeOnDelete();
            $table->string('nama');
            $table->string('kontak');
            $table->text('pesan');
            $table->timestamps();
        });

        Schema::create('produk_blud_laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_blud_id')->constrained('produk_bluds')->cascadeOnDelete();
            $table->string('kategori');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_blud_laporans');
        Schema::dropIfExists('produk_blud_penawarans');
    }
};
