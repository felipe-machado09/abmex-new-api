<?php

namespace Tests\Feature;

use App\Models\{Address, User};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_create_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $userData = [
            'name'         => 'John Doe',
            'email'        => 'johndoe@example.com',
            'password'     => 'password123',
            'phone_number' => '11999999999',
            'terms'        => 1,
            // Adicione outros campos do usuário, se necessário
        ];

        $checkData = [
            'name'  => 'John Doe',
            'email' => 'johndoe@example.com',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $checkData);
    }

    public function test_can_list_users()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/user');
        $response->assertStatus(200);

        $content = $response->getContent();

        $decodedContent = json_decode($content, true);
    }

    public function test_can_get_user_auth()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/me');
        $response->assertStatus(200);

        $content = $response->getContent();

        $decodedContent = json_decode($content, true);
        $this->assertArrayHasKey('data', $decodedContent);
        $userDecodedContent = $decodedContent['data']['user'];

        $this->assertArrayHasKey('email', $userDecodedContent);
        $this->assertArrayHasKey('name', $userDecodedContent);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name'  => 'Updated Name',
            'email' => 'updated@example.com',
        ];
        Sanctum::actingAs($user);

        $response = $this->putJson('/api/user/' . $user->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $updatedData);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/user/' . $user->id);

        $response->assertStatus(204);
    }

    public function test_can_create_onboarding_address()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $addressData = [
            'cep'        => fake()->postcode(),
            'street'     => fake()->streetAddress(),
            'district'   => fake()->streetName(),
            'city'       => fake()->city(),
            'state'      => fake()->streetSuffix(),
            'complement' => fake()->name(),
            'number'     => fake()->numberBetween(0, 1000),
        ];

        $response = $this->postJson('/api/onboarding/address', $addressData);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'cep',
                'street',
                'district',
                'city',
                'state',
                'complement',
                'number',
            ],
        ]);
    }

    public function test_can_create_onboarding_bank()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $bankData = [
            'name'           => fake()->name(),
            'account_type'   => fake()->numberBetween(1,2),
            'code'           => fake()->iban(),
            'agency'         => fake()->numberBetween(0, 20),
            'account_number' => fake()->swiftBicNumber(),
        ];

        $response = $this->postJson('/api/onboarding/bank', $bankData);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'user_id',
                'name',
                'account_type',
                'account_number',
                'agency',
            ],
        ]);
    }

    public function test_can_create_onboarding_company()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $companyData = [
            'cnpj'              => '64.498.940/0001-35',
            'fantasy_name'      => fake()->name(),
            'site'              => fake()->url(),
            'monthly_billing'   => fake()->numberBetween(1000, 1000000),
            'min_revenue_value' => fake()->numberBetween(10, 10000),
            'max_revenue_value' => fake()->numberBetween(10001, 1000000),
        ];

        $response = $this->postJson('/api/onboarding/company', $companyData);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'user_id',
                'cnpj',
                'fantasy_name',
                'site',
                'currency',
                'min_revenue_value',
                'max_revenue_value',
            ],
        ]);
    }
}
