<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'model' => 'required',
            'year' => 'required|string',
            'status' => 'required',
            'category' => 'nullable',
            'image_url' => 'nullable|url',
            'engine_sound_url' => 'nullable|url',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'avg_price' => 'nullable|numeric',
            'price_trend' => 'nullable|in:up,down,stable',
            'zero_to_sixty' => 'nullable|string',
            'top_speed' => 'nullable|string',
            'aerodynamics' => 'nullable|string',
            'braking' => 'nullable|string',
            'history' => 'nullable',
            'torque' => 'nullable',
            'transmission' => 'nullable',
            'drivetrain' => 'nullable',
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
