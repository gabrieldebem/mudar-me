<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'origin_id' => Address::factory(),
            'destination_id' => Address::factory(),
            'driver_id' => Driver::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 999),
            'distance_mt' => $this->faker->numberBetween(100, 9999),
            'scheduled_to' => today()->addWeek(),
        ];
    }
}
