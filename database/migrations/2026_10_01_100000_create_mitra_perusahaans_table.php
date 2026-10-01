<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name');
            $table->string('sector');
            $table->string('city');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_color')->nullable();
            $table->string('logo_text')->nullable();
            $table->boolean('is_mou_active')->default(true);
            $table->date('mou_until')->nullable();
            $table->json('programs')->nullable();
            $table->json('stats')->nullable();
            $table->text('address')->nullable();
            $table->string('distance_note')->nullable();
            $table->year('kemitraan_sejak')->nullable();
            $table->string('narahubung_nama')->nullable();
            $table->string('narahubung_jabatan')->nullable();
            $table->string('narahubung_wa')->nullable();
            $table->json('kelas_industri')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra_perusahaans');
    }
};
