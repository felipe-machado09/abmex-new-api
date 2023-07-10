<?php

use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;


test('list categories test', function () {

    $user = User::factory()->create();
    Sanctum::actingAs($user);
    
    Category::factory(10)->create();
   
    $response = $this->get(route('api-categories.index'));

    $response->assertOk();

});



