<?php

namespace App\Http\Resources;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Bank
 */
class OnboardingBankResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     *     @mixin Bank
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'user'           => new UserResource($this->whenLoaded('user')),
            'name'           => $this->name,
            'account_type'   => $this->account_type,
            'account_number' => $this->account_number,
            'agency'         => $this->agency,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
