<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Car extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'pros' => 'array',
        'cons' => 'array',
        'engine' => 'array',
        'hp' => 'array',
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class);
    }
}
