<?php

namespace App\Http\Requests;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrontendPropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city'      => ['nullable', 'string', 'max:50'],
        'country'   => ['nullable', 'string', 'max:80'],
        'min_price' => ['nullable', 'numeric', 'min:0'],
        'max_price' => ['nullable', 'numeric', 'min:0'],
        'bedrooms'  => ['nullable', 'integer', 'min:0', 'max:255'],
        'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
        'surface'   => ['nullable', 'integer', 'min:0'],
        'type'      => ['nullable', Rule::enum(PropertyType::class)],
        'status'    => ['nullable', Rule::enum(PropertyStatus::class)],
        'sort'      => ['nullable', 'string', 'in:latest,price_asc,price_desc'],
        ];
    }
}