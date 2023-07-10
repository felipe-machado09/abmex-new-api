<?php

namespace App\Services\Api\User;

use App\Models\Address;
use Throwable;

class OnboardingAddressService
{
    /**
     * @throws Throwable
     */
    public function store(array $data): Address
    {
        $user = auth()->user();

        return $user->address()->create($data);
    }
}
