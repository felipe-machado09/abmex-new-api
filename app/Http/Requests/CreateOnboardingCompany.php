<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOnboardingCompany extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cnpj'              => ['required', 'cnpj'],
            'fantasy_name'      => ['required'],
            'site'              => ['required', 'url'],
            'currency'          => ['nullable', Rule::in(['BRL', 'USD'])],
            'min_revenue_value' => ['required', 'min:1', 'numeric'],
            'max_revenue_value' => ['required', 'min:1', 'numeric', 'gt:min_revenue_value'],
        ];
    }
}
