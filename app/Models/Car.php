<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Car extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;
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
            $car->data_completion = $car->calculateDataCompletion();
        });
    }

    public function calculateDataCompletion(): int
    {
        $fields = [
            'model', 'year', 'category', 'image_url', 
            'zero_to_sixty', 'top_speed', 'history', 
            'torque', 'transmission', 'drivetrain',
            'engine_sound_url', 'min_price', 'max_price', 
            'price_trend', 'marketplace_url'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            $val = $this->$field;
            if (is_numeric($val) || !empty($val)) $filled++;
        }

        $extraChecks = 0;
        if (!empty($this->pros) && count($this->pros) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->cons) && count($this->cons) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->engine) && count($this->engine) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($this->gallery) && count($this->gallery) > 0) { $filled++; }
        $extraChecks++;

        // Using relationship count if loaded, otherwise check DB
        if ($this->relationLoaded('brands')) {
            if ($this->brands->count() > 0) $filled++;
        } elseif ($this->brands()->exists()) {
            $filled++;
        }
        $extraChecks++;

        $totalPossible = count($fields) + $extraChecks;

        return round(($filled / $totalPossible) * 100);
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
