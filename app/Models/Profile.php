<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'location',
        'avatar_url',
        'bio',
        'bio_long',
        'cv_url',
        'socials',
        'extras',
    ];

    protected $casts = [
        'socials' => 'array',
        'extras' => 'array',
    ];
}
