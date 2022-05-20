<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Driver;
use App\Models\Google\DistanceAndDuration;
use App\Models\Travel;
use App\Repositories\Clients\GoogleMapsDistance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Matcher\Type;
use Tests\TestCase;

class TravelApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function testCanListTravel()
    {
        $travel = Travel::factory()
            ->count(10)
            ->create();

        $this->get('/api/travels')
            ->assertSuccessful()
            ->assertJson(['data' => $travel->toArray()]);
    }

    /** @test */
    public function testCanShowTravel()
    {
        $travel = Travel::factory()
            ->create();

        $this->get('/api/travels/' . $travel->id)
            ->assertSuccessful()
            ->assertJson($travel->toArray());
    }

    /** @test */
    public function testCanCreateTravel()
    {
        Driver::factory()
            ->create();

        $postData = [
            'origin_id' => Address::factory()->create()->id,
            'destination_id' => Address::factory()->create()->id,
            'scheduled_to' => today()->addWeek()->format('Y-m-d'),
        ];

        $fakeGoogleResponse = new DistanceAndDuration(json_decode(json_encode([
            "distance" => [
                "text" => "5.0 km",
                "value" => 4979,
            ],
            "duration" => [
                "text" => "10 mins",
                "value" => 580,
            ],
            "status" => "OK"
        ])));

        $this->partialMock(GoogleMapsDistance::class)
            ->shouldReceive('getDistance')
            ->with(new Type('string'), new Type('string'))
            ->andReturn($fakeGoogleResponse);

        $this->post('/api/travels', $postData)
            ->assertSuccessful();

        $this->assertDatabaseHas('travel',  $postData);
    }

    /** @test */
    public function testCanUpdateTravel()
    {
        $travel = Travel::factory()
            ->create();

        $putData = [
            'origin_id' => Address::factory()->create()->id,
            'destination_id' => Address::factory()->create()->id,
        ];

        $this->put("/api/travels/{$travel->id}", $putData)
            ->assertSuccessful();

        $this->assertDatabaseHas('travel',  $putData);
    }

    /** @test */
    public function testCanDeleteTravel()
    {
        $travel = Travel::factory()
            ->create();

        $this->delete("/api/travels/{$travel->id}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('travel',  ['id' => $travel->id]);
    }
}
