<?php

namespace App\Http\Resources;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category'),
            'name' => $this->name,
            'description' => $this->description,
            'status' => ProductStatusEnum::tryFrom($this->status),
            'available_sell' => $this->available_sell,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}