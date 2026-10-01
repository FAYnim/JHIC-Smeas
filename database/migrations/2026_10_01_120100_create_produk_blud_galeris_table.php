<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_blud_galeris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_blud_id')->constrained('produk_bluds')->cascadeOnDelete();
            $table->string('image_url');
            $table->string('caption')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_blud_galeris');
    }
};
