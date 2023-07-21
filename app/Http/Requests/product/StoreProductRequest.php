<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Enums\ProductStatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin Product
 */
class StoreProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'category_id' => ['nullable', Rule::exists('categories', 'id')],
            'description' => ['nullable', 'string', 'min:100','max:1000'],
            'available_sell' => ['nullable', 'boolean'],
            'status' => ['required', 'string', new Enum(ProductStatusEnum::class)],
            'files' => ['nullable','array'], 
            'files.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'offers' => ['nullable', 'array'],
            'offers.*.name' => ['required', 'max:255', 'string'],
            'offers.*.price' => ['required', 'numeric'],
            'offers.*.recurrency_setup' => ['required', 'json'],
            'offers.*.pages_setup' => ['required', 'json'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}