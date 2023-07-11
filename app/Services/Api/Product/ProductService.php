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

    public function index(array $filter)
    {
        $product = Product::query();

        if(empty($filter)) {
            return $product->orderBy('name', 'asc')->get();
        }

        if (isset($filter['status'])) {
            $product->where('status', $filter['status']);
        }

        if (isset($filter['name'])) {
            $product->where('name', 'like', '%' . $filter['name'] . '%');
        }


        if (isset($filter['category_id'])) {
            $product->where('category_id', $filter['category_id']);
        }

        return $product->orderBy('name', 'asc')->get();
    }

    public function store(StoreProductRequest $request): Product|Model
    {
        $product = Product::create($request->validated());

        if ($request->hasFile('image') && $product) {
            $this->storeFileStorageProduct($request['image'], $product->id);
        }

        return $product;
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

    public function storeFileStorageProduct($data, $product_id)
    {
        $img = $this->storeFile($data);
        $file_storage = $this->FileStorageProduct($product_id, $img->id);
        return $file_storage;
    }
}
