<?php

namespace App\Services\Api\Offer;

use App\Http\Requests\Offer\OfferRequest;
use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Collection;

class OfferService
{
    public function index(OfferRequest $request): Collection
    {
        $offer = Offer::query();
        return $offer->orderBy('name', 'asc')->get();
    }

    public function store(StoreOfferRequest $request): Offer
    {
        $data = $request->validated();
        $offer = Offer::create($data);

        return $offer;
    }

    public function show(Offer $offer): Offer
    {
        return $offer;
    }

    public function update(UpdateOfferRequest $request, Offer $offer): Offer
    {
        $offer->update($request->validated());
        return $offer;
    }

    public function destroy(Offer $offer): bool
    {
        return $offer->delete();
    }
}
