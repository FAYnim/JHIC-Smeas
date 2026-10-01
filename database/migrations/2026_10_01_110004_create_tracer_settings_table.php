<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat_keterserapan');
            $table->string('keterserapan_trend');
            $table->string('keterserapan_trend_warna');
            $table->string('masa_tunggu');
            $table->string('masa_tunggu_sub');
            $table->string('masa_tunggu_sub_warna');
            $table->string('kesesuaian');
            $table->string('kesesuaian_sub');
            $table->string('kesesuaian_sub_warna');
            $table->string('total_alumni');
            $table->string('total_alumni_sub');
            $table->string('total_alumni_sub_warna');
            $table->text('catatan_bmw')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracer_settings');
    }
};
