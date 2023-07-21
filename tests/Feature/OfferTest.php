<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



test('list all offers', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Offer::factory()
        ->count(5)
        ->create();

    $response = $this->getJson(route('api-offers.index'));

    $response->assertStatus(200);
});

test('create a offer', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $product = Product::factory()->create();
    $recurrency = ['none', 'weekly', 'monthly', 'quarterly', 'semiannually', 'annually', 'custom'];
    $key = array_rand($recurrency);
    
    $offerData = [
        'product_id' => $product->id,
        'name' => 'Product Test',
        'price' => 100.00,
        'recurrency_setup' => $recurrency[$key],
        'pages_setup' => 'Lorem Ipsum comes from sections',
    ];

    $response = $this->postJson(route('api-offers.store'), $offerData);

    $response->assertStatus(201);

    expect(Offer::where('name', 'Product Test')
    ->exists())
    ->toBeTrue();
});

test('update a offer', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $product = Product::factory()->create();
    $offer = Offer::factory()->create();
    $recurrency = ['none', 'weekly', 'monthly', 'quarterly', 'semiannually', 'annually', 'custom'];
    $key = array_rand($recurrency);

    $updatedData = [
        'name' => 'Updated Product',
        'product_id' => $product->id,
        'price' => 150.00,
        'recurrency_setup' => $recurrency[$key],
        'pages_setup' => 'Lorem Ipsum comes from sections',
    ];

    $response = $this->putJson(route('api-offers.update', $offer->id), $updatedData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);
    $offer->refresh();

    expect($offer->name)->toBe('Updated Product');
});

test('delete a offer', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $offer = Offer::factory()->create();
    $response = $this->deleteJson(route('api-offers.destroy', $offer->id));  

    $response->assertNoContent();

    expect(Offer::find($offer->id))->toBeNull();
});
