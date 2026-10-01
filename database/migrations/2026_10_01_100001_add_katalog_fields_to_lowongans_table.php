<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->integer('gaji_min')->nullable();
            $table->integer('gaji_max')->nullable();
            $table->string('tipe_pekerjaan')->nullable();
            $table->string('pengalaman')->nullable();
            $table->string('bidang_industri')->nullable();
            $table->string('jenjang_pendidikan')->nullable();
            $table->boolean('fresh_graduate_ok')->default(false);
            $table->string('logo_color')->nullable();
            $table->foreignId('mitra_id')->nullable()->constrained('mitra_perusahaans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mitra_id');
            $table->dropColumn([
                'gaji_min',
                'gaji_max',
                'tipe_pekerjaan',
                'pengalaman',
                'bidang_industri',
                'jenjang_pendidikan',
                'fresh_graduate_ok',
                'logo_color',
            ]);
        });
    }
};
