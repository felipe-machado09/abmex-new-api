<?php

namespace App\Services\Api\User;

use App\Models\Bank;
use Throwable;

class OnboardingBankService
{
    /**
     * @throws Throwable
     */
    public function store(array $data): Bank
    {
        $user = auth()->user();

        return $user->bank()->create($data);
    }
}
