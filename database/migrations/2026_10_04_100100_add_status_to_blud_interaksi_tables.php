<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_blud_penawarans', function (Blueprint $table) {
            $table->string('status')->default('baru')->after('pesan');
            $table->text('catatan_internal')->nullable()->after('status');
            $table->foreignId('ditangani_oleh')->nullable()->after('catatan_internal')
                ->constrained('users')->nullOnDelete();
        });

        foreach (['produk_blud_laporans', 'produk_blud_komentars'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('status')->default('baru');
                $table->text('catatan_internal')->nullable();
                $table->foreignId('ditangani_oleh')->nullable()
                    ->constrained('users')->nullOnDelete();
                $table->timestamp('ditangani_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['produk_blud_komentars', 'produk_blud_laporans'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('ditangani_oleh');
                $table->dropColumn(['status', 'catatan_internal', 'ditangani_at']);
            });
        }

        Schema::table('produk_blud_penawarans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ditangani_oleh');
            $table->dropColumn(['status', 'catatan_internal']);
        });
    }
};
