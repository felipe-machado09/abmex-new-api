<?php

namespace App\Services\Api\Product;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Traits\FilesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    use FilesTrait;
    public function search(): LengthAwarePaginator
    {
        return Product::query()->paginate();
    }

    public function store(StoreProductRequest $request): Product|Model
    {
        return Product::create($request->validated());
    }

    public function show(Product $product): Product
    {
        return $product;
    }

    public function update(StoreProductRequest $request, Product $product): Product|Model
    {
        $product->update($request->validated());
        return $product;
    }

    public function destroy(Product $product): bool
    {
        return $product->delete();
    }
}