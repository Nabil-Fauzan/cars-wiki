<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComparisonSet extends Model
{
    protected $fillable = ['user_id', 'name', 'car1_id', 'car2_id', 'car3_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car1(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car1_id', 'model_id');
    }

    public function car2(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car2_id', 'model_id');
    }

    public function car3(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car3_id', 'model_id');
    }
}
