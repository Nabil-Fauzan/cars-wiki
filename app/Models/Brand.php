<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Brand extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'slug', 'logo_url', 'country', 'description'];

    protected static function booted()
    {
        static::creating(function (Brand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = \Illuminate\Support\Str::slug($brand->name);
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'country', 'description'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }
}
