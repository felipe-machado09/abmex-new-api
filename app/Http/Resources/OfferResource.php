<?php

namespace App\Http\Resources;

use App\Enums\RecurrenceEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product'),   
            'name' => $this->name,
            'price' => $this->price,
            'recurrency_setup' => RecurrenceEnum::tryFrom($this->recurrency_setup),
            'pages_setup' => $this->pages_setup,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
