<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TourRequest extends FormRequest
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
        $tourId = $this->route('tour');

        $commonRules = [
            'destination_id' => 'required|exists:destinations,id',

            'title' => 'required|array',
            'title.en' => 'required|string|max:200',
            'title.de' => 'nullable|string|max:200',
            'title.fr' => 'nullable|string|max:200',

            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.de' => 'nullable|string',
            'description.fr' => 'nullable|string',

            'capacity' => 'required|integer|min:1|max:1000',
            'rating' => 'nullable|numeric|min:0|max:5',

            'hotel_info' => 'nullable|array',
            'hotel_info.en' => 'nullable|array',
            'hotel_info.fr' => 'nullable|array',
            'hotel_info.de' => 'nullable|array',

            'package_info' => 'nullable|array',
            'package_info.en' => 'nullable|array',
            'package_info.fr' => 'nullable|array',
            'package_info.de' => 'nullable|array',

            'tour_type'      => 'required|in:hotel,honeymoon,trip',

            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'user_add_id' => 'nullable|exists:users,id',
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
            'destination_id.required' => 'The destination is required.',
            'destination_id.exists' => 'The selected destination does not exist.',

            'title.required' => 'The tour title is required.',
            'title.en.required' => 'The English title is required.',
            'title.en.max' => 'The English title must not exceed 200 characters.',

            'rating.numeric' => 'The rating must be a valid number.',
            'rating.min' => 'The rating must be at least 0.',
            'rating.max' => 'The rating must not exceed 5.',

            'capacity.required' => 'The capacity is required.',
            'capacity.integer' => 'The capacity must be a number.',
            'capacity.min' => 'The capacity must be at least 1.',
            'capacity.max' => 'The capacity must not exceed 1000.',
            'tour_type.required' => 'The destination is required.',
            
            'image.*.image' => 'Each uploaded file must be an image.',
            'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.*.max' => 'Each image must not exceed 2MB.',

            'user_add_id.exists' => 'The user who added this tour does not exist.',
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
        // Clean up numeric fields
        if ($this->has('rating')) {
            $this->merge([
                'rating' => (float) $this->rating
            ]);
        }

        if ($this->has('capacity')) {
            $this->merge([
                'capacity' => (int) $this->capacity
            ]);
        }
    }
}
