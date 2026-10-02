<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'kategori',
        'published_at',
        'image_url',
        'image_path',
        'reading_time',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getDisplayImageAttribute(): ?string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        return $this->image_url;
    }
}
