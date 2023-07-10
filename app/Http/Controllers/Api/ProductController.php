<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\Api\Product\ProductService;

class ProductController extends Controller
{

    public function __construct(
      private readonly ProductService $productService
    ) {}

    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->store($request)
        );
    }
}