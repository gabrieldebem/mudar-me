<?php

namespace Tests\Feature;

use App\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DriverApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function testCanListDriver()
    {
        $driver = Driver::factory()
            ->count(10)
            ->create();

        $this->get('/api/drivers')
            ->assertSuccessful()
            ->assertJson(['data' => $driver->toArray()]);
    }

    /** @test */
    public function testCanShowDriver()
    {
        $driver = Driver::factory()
            ->create();

        $this->get('/api/drivers/' . $driver->id)
            ->assertSuccessful()
            ->assertJson($driver->toArray());
    }

    /** @test */
    public function testCanCreateDriver()
    {
        $postData = [
            'name' => $this->faker->name(),
            'document' => $this->faker->text(11),
            'truck' => $this->faker->name(),
            'amount_km' => $this->faker->randomFloat(2, 10, 20),
        ];
        $this->post('/api/drivers', $postData)
            ->assertSuccessful();

        $this->assertDatabaseHas('drivers',  $postData);
    }

    /** @test */
    public function testCanUpdateDriver()
    {
        $driver = Driver::factory()
            ->create();

        $putData = [
            'name' => $this->faker->name(),
            'document' => $this->faker->text(11),
            'truck' => $this->faker->name(),
            'amount_km' => $this->faker->randomFloat(2, 10, 20),
        ];
        $this->put("/api/drivers/{$driver->id}", $putData)
            ->assertSuccessful();

        $this->assertDatabaseHas('drivers',  $putData);
    }

    /** @test */
    public function testCanDeleteDriver()
    {
        $driver = Driver::factory()
            ->create();

        $this->delete("/api/drivers/{$driver->id}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('drivers',  ['id' => $driver->id]);
    }
}
