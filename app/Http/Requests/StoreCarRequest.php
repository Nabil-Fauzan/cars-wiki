<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // We will use Policy for this later
    }

    public function rules(): array
    {
        return [
            'model_id' => 'required|unique:cars,model_id',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|string',
            'category' => 'nullable|string',
            'image_url' => 'nullable|url',
            'engine_sound_url' => 'nullable|url',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'avg_price' => 'nullable|numeric',
            'price_trend' => 'nullable|in:up,down,stable',
            'zero_to_sixty' => 'nullable|numeric',
            'top_speed' => 'nullable|integer',
            'aerodynamics' => 'nullable|numeric',
            'braking' => 'nullable|integer',
            'history' => 'nullable|string',
            'torque' => 'nullable|string',
            'transmission' => 'nullable|string',
            'drivetrain' => 'nullable|string',
            'brand_ids' => 'nullable|array',
            'brand_ids.*' => 'exists:brands,id',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'hp_primary' => 'nullable|string',
            'hp_secondary' => 'nullable|string',
            'engine_primary' => 'nullable|string',
            'engine_secondary' => 'nullable|string',
            'gallery_1' => 'nullable|url',
            'gallery_2' => 'nullable|url',
            'gallery_3' => 'nullable|url',
        ];
    }
}
