<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;

use Tests\TestCase;

test('create product active', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);

    $payload = [
        'category_id' => $category->id,
        'name' => 'PRODUTO TESTE',
        'status' => 'active',
        'available_sell' => 1,
    ];

    $response = $this->postJson(route('api-products.index'), $payload);

    $response->assertStatus(201);

    expect(Product::where('name', 'PRODUTO TESTE')
        ->exists())
        ->toBeTrue();
});


test('create product inactive', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);

    $payload = [
        'category_id' => $category->id,
        'name' => 'PRODUTO TESTE',
        'status' => 'inactive',
        'available_sell' => 1,
    ];

    $response = $this->postJson(route('api-products.index'), $payload);

    $response->assertStatus(201);

    expect(Product::where('name', 'PRODUTO TESTE')
        ->where('available_sell', 0)
        ->exists())
        ->toBeTrue();
});


test('create product blocked', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);

    $payload = [
        'category_id' => $category->id,
        'name' => 'PRODUTO TESTE',
        'status' => 'blocked',
        'available_sell' => 1,
    ];

    $response = $this->postJson(route('api-products.index'), $payload);

    $response->assertStatus(201);

    expect(Product::where('name', 'PRODUTO TESTE')
        ->where('available_sell', 0)
        ->exists())
        ->toBeTrue();
});


test('create product sketch', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);

    $payload = [
        'category_id' => $category->id,
        'name' => 'PRODUTO TESTE',
        'status' => 'sketch',
        'available_sell' => 1,
    ];

    $response = $this->postJson(route('api-products.index'), $payload);

    $response->assertStatus(201);

    expect(Product::where('name', 'PRODUTO TESTE')
        ->where('available_sell', 0)
        ->exists())
        ->toBeTrue();
});


test('update product', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);
    $product = Product::factory()->create();

    $updatedProductData = [
        "category_id" => $category->id,
        "name" => "teste update",
        "status" => "active",
        "available_sell" => "0",
    ];

    $response = $this->putJson(route('api-products.update', $product->id), $updatedProductData);
    $response->assertOk();
    $response->assertJsonFragment($updatedProductData);

    expect(Product::where('name', $updatedProductData['name'])
        ->where('category_id', $updatedProductData['category_id'])
        ->exists())
        ->toBeTrue();
});


test('destroy product', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $product = Product::factory()->create();

    $response = $this->deleteJson(route('api-products.destroy', $product->id));

    $response->assertNoContent();
    expect(Product::find($product->id))->toBeNull();
});

test('create a product and offers', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    Sanctum::actingAs($user);

    $productData = [
        'name' => 'Product Test',
        'user_id' => $user->id,
        'category_id' => $category->id,
        'available_sell' => true,
        'status' => 'active',
        'offers' => [
            [
                'name' => 'Offer 1',
                'price' => 100,
                'recurrency_setup' => json_encode(['option1' => 'value1']),
                'pages_setup' => json_encode(['option2' => 'value2']),
            ],
            [
                'name' => 'Offer 2',
                'price' => 200,
                'recurrency_setup' => json_encode(['option3' => 'value3']),
                'pages_setup' => json_encode(['option4' => 'value4']),
            ],
        ],
    ];

    $response = $this->postJson(route('api-products.index'), $productData);

    expect(Product::where('name', $productData['name'])
        ->exists())
        ->toBeTrue();

    expect(Offer::where('name', $productData['offers'][0]['name'])
    ->exists())
    ->toBeTrue();

    expect(Offer::where('name', $productData['offers'][1]['name'])
    ->exists())
    ->toBeTrue();
});
