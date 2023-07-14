<?php

namespace Tests\Feature;

use App\Models\Category;
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