<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo_url', 'country', 'description'];

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }
}
