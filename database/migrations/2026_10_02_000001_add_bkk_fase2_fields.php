<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('status_kuota');
            $table->string('logo_path')->nullable()->after('logo_color');
        });

        Schema::table('mitra_perusahaans', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('logo_text');
        });
    }

    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn(['is_published', 'logo_path']);
        });

        Schema::table('mitra_perusahaans', function (Blueprint $table) {
            $table->dropColumn(['logo_path']);
        });
    }
};
