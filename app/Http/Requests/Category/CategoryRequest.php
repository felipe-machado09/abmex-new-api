<?php

namespace App\Http\Requests\Category;

use App\Enums\CategoryEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CategoryRequest extends FormRequest
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
    public function rules(Request $request): array
    {

        return [
            'name'  => 'nullable|string|max:255',
            'type'  => ['nullable', 'string', new Enum(CategoryEnum::class)]
        ];
    }
}
