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
        Schema::create('calon_siswas', function (Blueprint $table) {
            $table->id();

            // Identitas Siswa
            $table->string('nisn', 10)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Pria', 'Wanita'])->nullable();
            $table->string('asal_sekolah');
            $table->string('nomor_telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();

            // Data Orang Tua
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('wa_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('wa_ibu')->nullable();

            // Pilihan Jurusan & Jalur
            $table->string('jalur_pendaftaran')->nullable();
            $table->string('jurusan_pilihan')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
