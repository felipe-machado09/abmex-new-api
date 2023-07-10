<?php

namespace App\Services\Api\Category;

use App\Models\Category;
use App\Enums\CategoryEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function index(array $filter): Collection
    {
        $category = Category::query();
        if(empty($filter)){
            return $category->orderBy('name', 'asc')->get();
        }

        if (isset($filter['type'])) {
            $category->where('type', $filter['type']);
        } 

        if (isset($filter['name'])) {
            $category->where('name', 'like', '%' . $filter['name'] . '%');
        }

        return $category->orderBy('name', 'asc')->get();
    }

}