<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComparisonLog extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'car_a_id';
    public $incrementing = false;
    protected $fillable = ['car_a_id', 'car_b_id', 'created_at'];

    public function carA(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_a_id');
    }

    public function carB(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_b_id');
    }
}
