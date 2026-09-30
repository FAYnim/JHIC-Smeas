<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt');
            $table->text('content');
            $table->string('kategori')->default('Umum');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
