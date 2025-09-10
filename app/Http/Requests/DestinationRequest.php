<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DestinationRequest extends FormRequest
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
        // لو بتعمل update هتجيب الـ id من الروت
        $destinationId = $this->route('id');

        $commonRules = [
            'name' => 'required|array',
            'name.en' => 'required|string|max:100',
            'name.de' => 'nullable|string|max:100',
            'name.fr' => 'nullable|string|max:100',

            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.de' => 'nullable|string',
            'description.fr' => 'nullable|string',

            'slug' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('destinations')->ignore($destinationId),
            ],

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB

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
            'name.required' => 'The destination name is required.',
            'name.en.required' => 'The English name is required.',
            'name.en.max' => 'The English name must not exceed 100 characters.',
            'slug.unique' => 'This slug is already taken.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image must not exceed 2MB.',
            'user_add_id.exists' => 'The user who added this destination does not exist.',
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
        if ($this->has('slug') && $this->slug) {
            $this->merge([
                'slug' => strtolower(trim($this->slug))
            ]);
        }
    }
}
