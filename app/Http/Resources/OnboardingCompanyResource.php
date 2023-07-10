<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class OnboardingCompanyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'user_id'           => $this->user_id,
            'user'              => new UserResource($this->whenLoaded('user')),
            'cnpj'              => $this->cnpj,
            'fantasy_name'      => $this->fantasy_name,
            'site'              => $this->site,
            'currency'          => $this->currency,
            'min_revenue_value' => $this->min_revenue_value,
            'max_revenue_value' => $this->max_revenue_value,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
