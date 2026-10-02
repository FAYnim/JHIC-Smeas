<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_bluds', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('tipe')->index(); // showcase | kustom
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('jurusan_nama');
            $table->string('jurusan_slug')->index();
            $table->text('deskripsi');
            $table->bigInteger('harga_min')->nullable();
            $table->bigInteger('harga_max')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('rating_count')->nullable();
            $table->string('terjual')->nullable();
            $table->string('pengiriman')->nullable();
            $table->string('kategori')->nullable();
            $table->string('stok')->nullable();
            $table->string('opsi_custom')->nullable();
            $table->string('quantity_per_pack')->nullable();
            $table->date('tanggal_pembuatan')->nullable();
            $table->integer('angkatan')->nullable();
            $table->string('didukung_oleh')->nullable();
            $table->string('ketua_tim')->nullable();
            $table->json('anggota_tim')->nullable();
            $table->string('jurusan_logo_color')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('penilaian_count')->nullable();
            $table->string('produk_count')->nullable();
            $table->string('presentase_chat')->nullable();
            $table->string('waktu_chat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_bluds');
    }
};
