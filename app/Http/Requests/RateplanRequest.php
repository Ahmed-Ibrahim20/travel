<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RateplanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rateplanId = $this->route('rateplan');

        $commonRules = [
            'tour_id' => 'required|exists:tours,id',
            
            'name' => 'required|array',
            'name.en' => 'required|string|max:150',
            'name.de' => 'nullable|string|max:150',
            'name.fr' => 'nullable|string|max:150',

            'price' => 'required|numeric|min:0|max:999999.99',
            'currency' => 'required|string|size:3|in:EGP,USD,EUR,GBP',

            'room_type' => 'nullable|string|in:Single,Double,Triple',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'board_type' => 'nullable|string|in:All Inclusive,Half Board,Full Board,Bed & Breakfast',
            'transportation' => 'nullable|string|in:No transfers,Bus,Private car',

            'details' => 'nullable|array',
            'details.en' => 'nullable|string',
            'details.de' => 'nullable|string',
            'details.fr' => 'nullable|string',
        ];

        if ($this->isMethod('POST')) {
            return $commonRules;
        }

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            return $commonRules;
        }

        return [];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'tour_id.required' => 'The tour is required.',
            'tour_id.exists' => 'The selected tour does not exist.',
            
            'name.required' => 'The rate plan name is required.',
            'name.en.required' => 'The English name is required.',
            'name.en.max' => 'The English name must not exceed 150 characters.',
            
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'price.max' => 'The price must not exceed 999,999.99.',
            
            'currency.required' => 'The currency is required.',
            'currency.size' => 'The currency must be exactly 3 characters.',
            'currency.in' => 'The currency must be one of: EGP, USD, EUR, GBP.',
            
            'room_type.in' => 'The room type must be one of: Single, Double, Triple.',
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date must be today or later.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',
            'board_type.in' => 'The board type must be one of: All Inclusive, Half Board, Full Board, Bed & Breakfast.',
            'transportation.in' => 'The transportation must be one of: No transfers, Bus, Private car.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Clean up price field
        if ($this->has('price')) {
            $this->merge([
                'price' => (float) str_replace(',', '', $this->price)
            ]);
        }

        // Ensure currency is uppercase
        if ($this->has('currency')) {
            $this->merge([
                'currency' => strtoupper(trim($this->currency))
            ]);
        }
    }
}
