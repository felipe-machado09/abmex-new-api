<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $onboardingValues = [
            'company'    => $this->company,
            'address'    => $this->address,
            'bank'       => $this->bank,
            'next_code'  => $this->finishedOnboarding,
        ];

        return [
            'onboarding' => $onboardingValues,
            'stage' => $this->getOnboardStage($onboardingValues),
        ];
    }

    public function getOnboardStage($onboardingValues)
    {
        $stageValues = collect($onboardingValues)->filter(fn ($item) => !$item);

        return $stageValues->count() ? $stageValues->keys()->first() : $this->onboardStage;
    }
}
