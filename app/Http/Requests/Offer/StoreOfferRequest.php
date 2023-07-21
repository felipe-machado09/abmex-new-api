<?php

namespace App\Http\Requests\Offer;

use App\Enums\RecurrenceEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'recurrency_setup' =>  ['required', 'string', new Enum (RecurrenceEnum::class)],
            'pages_setup' => ['required', 'string'],
        ];
    }
}
