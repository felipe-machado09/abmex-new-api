<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\ProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Api\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(ProductRequest $request): AnonymousResourceCollection
    {
        return ProductResource::collection(
            $this->productService->index($request->validated())
        );

    }

    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->store($request)
        );
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return new ProductResource(
            $this->productService->update($request, $product)
        );
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->destroy($product);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
