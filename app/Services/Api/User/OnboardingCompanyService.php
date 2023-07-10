<?php

namespace App\Services\Api\User;

use App\Enums\CurrencyEnum;
use App\Models\Company;
use Throwable;

class OnboardingCompanyService
{
    /**
     * @throws Throwable
     */
    public function store(array $data): Company
    {
        $user = auth()->user();

        $data['currency'] = CurrencyEnum::BRL->value;

        return $user->company()->create($data);
    }
}
