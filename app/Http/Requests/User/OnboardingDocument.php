<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingDocument extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'image'],
            'social_contract' => ['required', 'mimes:pdf'],
        ];
    }
}
