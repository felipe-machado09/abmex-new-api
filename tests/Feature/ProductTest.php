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

