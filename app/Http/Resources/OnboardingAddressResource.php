<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Address
 */
class OnboardingAddressResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     *     @mixin Address
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'user'       => new UserResource($this->whenLoaded('user')),
            'cep'        => $this->cep,
            'street'     => $this->street,
            'district'   => $this->district,
            'city'       => $this->city,
            'state'      => $this->state,
            'complement' => $this->complement,
            'number'     => $this->number,
        ];
    }
}
