<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Car extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

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
        'last_link_check_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($car) {
            // Price integrity check
            if ($car->min_price > $car->max_price) {
                $temp = $car->min_price;
                $car->min_price = $car->max_price;
                $car->max_price = $temp;
            }
            
            $car->seo_score = $car->calculateSeoScore();
        });

        static::updated(function ($car) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'updated',
                'model_type' => Car::class,
                'model_id' => $car->id,
                'changes' => $car->getChanges(),
                'ip_address' => request()->ip(),
            ]);
        });

        static::created(function ($car) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'created',
                'model_type' => Car::class,
                'model_id' => $car->id,
                'ip_address' => request()->ip(),
            ]);
        });
    }

    public function calculateSeoScore(): int
    {
        $score = 0;
        if (strlen($this->history) > 200) $score += 30;
        if (strlen($this->history) > 500) $score += 20;
        if ($this->image_url) $score += 10;
        if (count($this->gallery ?? []) >= 3) $score += 10;
        if (count($this->pros ?? []) >= 3) $score += 10;
        if (count($this->cons ?? []) >= 3) $score += 10;
        if ($this->category) $score += 10;
        
        return min(100, $score);
    }

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
