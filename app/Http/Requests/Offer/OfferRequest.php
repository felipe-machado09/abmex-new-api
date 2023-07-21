<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'product_id' => ['nullable', 'exists:products,id'],
            'name' => ['nullable', 'max:255', 'string'],
            'price' => ['nullable', 'numeric'],
            'recurrency_setup' => ['nullable', 'json'],
            'pages_setup' => ['nullable', 'json'],
        ];
    }
}
