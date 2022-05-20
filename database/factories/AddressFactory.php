<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'street' => $this->faker->streetAddress(),
            'number' => $this->faker->numberBetween(100, 999),
            'neighborhood' => $this->faker->text(15),
            'city' => $this->faker->city(),
            'state' => 'RS',
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
