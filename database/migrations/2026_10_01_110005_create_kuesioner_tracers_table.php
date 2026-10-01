<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuesioner_tracers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnis_id')->nullable()->constrained('alumnis')->nullOnDelete();
            $table->string('nisn', 10);
            $table->string('nama');
            $table->string('jurusan');
            $table->integer('tahun_lulus');
            $table->string('status_pekerjaan');
            $table->string('nama_perusahaan')->nullable();
            $table->string('posisi')->nullable();
            $table->string('masa_tunggu')->nullable();
            $table->string('rentang_gaji')->nullable();
            $table->string('relevansi')->nullable();
            $table->text('saran')->nullable();
            $table->boolean('is_konfirmasi')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioner_tracers');
    }
};
