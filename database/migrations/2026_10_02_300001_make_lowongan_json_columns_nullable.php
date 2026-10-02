<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->json('tanggung_jawab')->nullable()->change();
            $table->json('kualifikasi')->nullable()->change();
            $table->json('dokumen')->nullable()->change();
            $table->json('benefits')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Tidak dikembalikan ke NOT NULL karena data lama bisa berisi NULL.
    }
};
