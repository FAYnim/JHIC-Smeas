<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagangApplication extends Model
{
    use HasFactory;

    protected $table = 'magang_applications';

    protected $fillable = [
        'lowongan_id',
        'nisn',
        'registration_code',
        'status',
        'documents',
    ];

    protected function casts(): array
    {
        return [
            'documents' => 'array',
        ];
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
