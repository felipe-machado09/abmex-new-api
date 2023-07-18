<?php

namespace App\Services\Api\Product;

use App\Models\Product;
use App\Traits\FilesTrait;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Product\ProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Offer;

class ProductService
{
    use FilesTrait;
    public function search(): LengthAwarePaginator
    {
        return Product::query()->paginate();
    }

    public function index(ProductRequest $request): Collection
    {
        $product = Product::query();
        $filter = $request;
        $product->with('images');
        $product->where('user_id', auth()->user()->id);

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
        $data = $request->validated();
        $product = Product::create($request->validated());
        $disk = 's3-product-public';
        $visibility = 'public';
        
        if(Arr::has($data, 'files')) {
            if(count($data['files']) > 0) {
                foreach ($data['files'] as $file) {
                    $img = $this->storeFile($file, $disk, $visibility);
                    $this->assignFileToProduct($product->id, $img->id);
                }
            }
        }

        if($request->offers){
            foreach($request->offers as $item)
            {
                $offer = new Offer($item);
                $product->offers()->save($offer);
            }         
        }
        
        $product->load('images');

        return $product;
    }

    public function show(Product $product): Product
    {
        return $product;
    }

    public function update(UpdateProductRequest $request, Product $product): Product|Model
    {
        $product->update($request->validated());
        return $product;
    }

    public function destroy(Product $product): bool
    {
        return $product->delete();
    }
}

