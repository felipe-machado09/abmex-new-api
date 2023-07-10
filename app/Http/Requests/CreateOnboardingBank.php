<?php

namespace App\Http\Requests;

use App\Enums\BankEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOnboardingBank extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => ['required', 'min:3'],
            'code'           => ['required', 'min:1'],
            'agency'         => ['required', 'min:1'],
            'account_type'   => ['required', 'min:1', new Enum(BankEnum::class)],
            'account_number' => ['required', 'min:5'],
        ];
    }
}
