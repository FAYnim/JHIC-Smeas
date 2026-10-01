<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('calon_siswas', 'tempat_lahir')) {
            return;
        }

        Schema::table('calon_siswas', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('status_ayah')->nullable()->after('alamat');
            $table->string('nik_ayah', 16)->nullable()->after('nama_ayah');
            $table->string('pendidikan_ayah')->nullable()->after('nik_ayah');
            $table->string('pekerjaan_ayah_lainnya')->nullable()->after('pekerjaan_ayah');
            $table->string('penghasilan_ayah')->nullable()->after('pekerjaan_ayah_lainnya');
            $table->string('status_ibu')->nullable()->after('wa_ayah');
            $table->string('nik_ibu', 16)->nullable()->after('nama_ibu');
            $table->string('pendidikan_ibu')->nullable()->after('nik_ibu');
            $table->string('pekerjaan_ibu_lainnya')->nullable()->after('pekerjaan_ibu');
            $table->string('penghasilan_ibu')->nullable()->after('pekerjaan_ibu_lainnya');
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswas', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'status_ayah',
                'nik_ayah',
                'pendidikan_ayah',
                'pekerjaan_ayah_lainnya',
                'penghasilan_ayah',
                'status_ibu',
                'nik_ibu',
                'pendidikan_ibu',
                'pekerjaan_ibu_lainnya',
                'penghasilan_ibu',
            ]);
        });
    }
};
