<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProductStatusEnum;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
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
                    'name' => ['required', 'string', 'max:255'],
                    'user_id' => ['required', Rule::exists('users', 'id')],
                    'category_id' => ['nullable', Rule::exists('categories', 'id')],
                    'description' => ['nullable', 'string', 'min:100','max:1000'],
                    'available_sell' => ['nullable', 'boolean'],
                    'status' => ['required', 'string', new Enum(ProductStatusEnum::class)]
                ];

    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
