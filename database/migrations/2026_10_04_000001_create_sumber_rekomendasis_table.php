<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sumber_rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->string('kategori')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sumber_rekomendasis');
    }
};
