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
