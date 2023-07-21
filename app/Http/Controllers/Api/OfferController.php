<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offer\OfferRequest;
use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Services\Api\Offer\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    public function __construct(private readonly OfferService $offerService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(OfferRequest $request): AnonymousResourceCollection
    {
        return OfferResource::collection(
            $this->offerService->index($request)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request): OfferResource
    {
        return new OfferResource(
            $this->offerService->store($request)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer): OfferResource
    {
        return new OfferResource(
            $this->offerService->show($offer)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        return new OfferResource(
            $this->offerService->update($request, $offer)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer): JsonResponse
    {
        $this->offerService->destroy($offer);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
