<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->company(),
            'postal_code'  => fake()->numerify('########'),
            'street'       => fake()->streetAddress(),
            'number'       => fake()->buildingNumber(),
            'complement'   => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->optional()->streetName(),
            'city'         => fake()->city(),
            'state'        => fake()->stateAbbr(),
            'phone'        => fake()->numerify('###########'),
            'email'        => fake()->optional()->safeEmail(),
        ];
    }
}
