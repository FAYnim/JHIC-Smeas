<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'speaker',
        'platform',
        'location',
        'start_date',
        'start_time',
        'registration_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
