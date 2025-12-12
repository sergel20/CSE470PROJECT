<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->id === $this->listing->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:5000',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'property_type' => 'required|string|in:apartment,house,villa,condo,townhouse,cottage,penthouse,studio',
            'guest_capacity' => 'required|integer|min:1|max:50',
            'bedrooms' => 'required|integer|min:0|max:20',
            'bathrooms' => 'required|integer|min:1|max:20',
            'price_per_night' => 'required|numeric|min:0.01|max:999999.99',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for your listing.',
            'description.required' => 'Please provide a description for your listing.',
            'description.min' => 'Description must be at least 10 characters.',
            'address.required' => 'Please provide the property address.',
            'property_type.required' => 'Please select a property type.',
            'guest_capacity.required' => 'Please specify guest capacity.',
            'price_per_night.required' => 'Please set a price per night.',
        ];
    }
}
