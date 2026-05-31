<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use App\Traits\CarMetrics;

class Car extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity, CarMetrics;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function getRouteKeyName(): string
    {
        return 'model_id';
    }

    protected $casts = [
        'gallery' => 'array',
        'pros' => 'array',
        'cons' => 'array',
        'engine' => 'array',
        'hp' => 'array',
        'torque' => 'array',
        'last_link_check_at' => 'datetime',
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
