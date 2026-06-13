<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'buyer';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['nullable', 'string', 'max:2000'],
            'desired_move_in' => ['nullable', 'date', 'after_or_equal:today'],
            'lease_duration_months'=> ['nullable', 'integer', 'min:1', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'desired_move_in.after_or_equal' => 'La date de déménagement doit être aujourd\'hui ou dans le futur.',
            'lease_duration_months.min'       => 'La durée minimale est de 1 mois.',
            'lease_duration_months.max'       => 'La durée maximale est de 120 mois.',
        ];
    }
}