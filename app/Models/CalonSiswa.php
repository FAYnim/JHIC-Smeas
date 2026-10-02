<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'nomor_telepon',
        'email',
        'alamat',
        'status_ayah',
        'nama_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'pekerjaan_ayah_lainnya',
        'penghasilan_ayah',
        'wa_ayah',
        'status_ibu',
        'nama_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'pekerjaan_ibu_lainnya',
        'penghasilan_ibu',
        'wa_ibu',
        'jalur_pendaftaran',
        'jurusan_pilihan',
        'status_verifikasi',
        'catatan_verifikasi',
    ];
}
