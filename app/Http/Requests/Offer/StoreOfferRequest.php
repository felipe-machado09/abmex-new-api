<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'recurrency_setup' => ['required', 'json'],
            'pages_setup' => ['required', 'json'],
        ];
    }
}
