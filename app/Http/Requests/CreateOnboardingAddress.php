<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOnboardingAddress extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cep'        => ['required', 'max:10'],
            'street'     => ['required'],
            'district'   => ['required'],
            'city'       => ['required'],
            'state'      => ['required'],
            'complement' => ['nullable'],
            'number'     => ['nullable', 'max:10'],
        ];
    }
}
