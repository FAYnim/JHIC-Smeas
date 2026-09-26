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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();

            // Company info
            $table->string('company_name');
            $table->string('company_short')->nullable();       // e.g. "Telkom Indonesia"
            $table->boolean('is_mitra_dudi')->default(false);

            // Job info
            $table->string('title');                            // e.g. "Software Engineer Intern (PKL)"
            $table->string('slug')->unique();
            $table->string('location');                         // e.g. "Surabaya, Jatim"
            $table->string('duration');                         // e.g. "6 Bulan (Jan - Jun)"
            $table->string('jurusan');                          // e.g. "Khusus RPL & SIJA"
            $table->integer('kuota')->default(0);
            $table->string('metode_kerja')->default('On-site'); // On-site / Remote / Hybrid

            // Content (stored as text, rendered in blade)
            $table->text('deskripsi');
            $table->json('tanggung_jawab');                     // array of strings
            $table->json('kualifikasi');                        // array of strings
            $table->json('dokumen');                            // array of {name, desc, type}
            $table->json('benefits');                           // array of strings

            // Registration info
            $table->date('batas_pendaftaran');
            $table->string('durasi_pelaksanaan');               // e.g. "6 Bulan (1 Semester)"
            $table->string('status_kuota')->default('Tersedia');

            // Contact
            $table->string('pokja_nama')->nullable();
            $table->string('pokja_koordinator')->nullable();
            $table->string('pokja_wa')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
