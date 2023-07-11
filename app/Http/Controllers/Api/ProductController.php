<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Api\Product\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->store($request)
        );
    }

    public function index(ProductRequest $request): AnonymousResourceCollection
    {
        return ProductResource::collection(
            $this->productService->index($request->validated())
        );

    }
}
