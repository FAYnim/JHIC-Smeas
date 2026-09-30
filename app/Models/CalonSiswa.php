<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'asal_sekolah',
        'nomor_telepon',
        'email',
        'alamat',
        'nama_ayah',
        'pekerjaan_ayah',
        'wa_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'wa_ibu',
        'jalur_pendaftaran',
        'jurusan_pilihan',
    ];
}
