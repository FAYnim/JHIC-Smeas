<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_blud_komentars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_blud_id')->constrained('produk_bluds')->cascadeOnDelete();
            $table->string('nama')->default('Anonim');
            $table->text('komentar');
            $table->tinyInteger('rating')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_blud_komentars');
    }
};
