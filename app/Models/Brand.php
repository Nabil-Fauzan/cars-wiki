<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Brand extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'logo_url', 'country', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'country', 'description'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }
}
