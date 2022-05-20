<?php

namespace Tests\Feature;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function testCanListAddress()
    {
        $address = Address::factory()
            ->count(10)
            ->create();

        $this->get('/api/address')
            ->assertSuccessful()
            ->assertJson(['data' => $address->toArray()]);
    }

    /** @test */
    public function testCanShowAddress()
    {
        $address = Address::factory()
            ->create();

        $this->get('/api/address/' . $address->id)
            ->assertSuccessful()
            ->assertJson($address->toArray());
    }

    /** @test */
    public function testCanCreateAddress()
    {
        $postData = [
            'street' => $this->faker->streetAddress(),
            'number' => $this->faker->numberBetween(100, 999),
            'neighborhood' => $this->faker->text(15),
            'city' => $this->faker->city(),
            'state' => 'RS',
            'postal_code' => $this->faker->postcode(),
        ];
        $this->post('/api/address', $postData)
            ->assertSuccessful();

        $this->assertDatabaseHas('addresses',  $postData);
    }

    /** @test */
    public function testCanUpdateAddress()
    {
        $address = Address::factory()
            ->create();

        $putData = [
            'street' => $this->faker->streetAddress(),
            'number' => $this->faker->numberBetween(100, 999),
            'neighborhood' => $this->faker->text(15),
            'city' => $this->faker->city(),
            'state' => 'RS',
            'postal_code' => $this->faker->postcode(),
        ];
        $this->put("/api/address/{$address->id}", $putData)
            ->assertSuccessful();

        $this->assertDatabaseHas('addresses',  $putData);
    }

    /** @test */
    public function testCanDeleteAddress()
    {
        $address = Address::factory()
            ->create();

        $this->delete("/api/address/{$address->id}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('addresses',  ['id' => $address->id]);
    }
}
