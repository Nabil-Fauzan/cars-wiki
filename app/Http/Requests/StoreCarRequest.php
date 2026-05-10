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
            'model_id' => 'required|unique:cars',
            'model' => 'required',
            'year' => 'required|string',
            'category' => 'nullable',
            'image_url' => 'nullable|url',
            'zero_to_sixty' => 'nullable|numeric',
            'top_speed' => 'nullable|integer',
            'aerodynamics' => 'nullable|numeric',
            'braking' => 'nullable|integer',
            'history' => 'nullable',
            'torque' => 'nullable',
            'transmission' => 'nullable',
            'drivetrain' => 'nullable',
            'brand_ids' => 'nullable|array',
            'brand_ids.*' => 'exists:brands,id',
        ];
    }
}
