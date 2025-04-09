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
            'name'                  => $this->faker->company,
            'sender_name'           => $this->faker->company,
            'street'                => $this->faker->streetName,
            'number'                => $this->faker->buildingNumber,
            'complement'            => $this->faker->optional()->secondaryAddress,
            'neighborhood'          => $this->faker->optional()->word,
            'city'                  => $this->faker->city,
            'state'                 => strtoupper($this->faker->stateAbbr),
            'phone'                 => $this->faker->phoneNumber(),
            'email'                 => $this->faker->email(),
            'postal_code'           => str_replace('-', '', $this->faker->postcode), // garante 8 dígitos sem traço
            'matrix_code'           => $this->faker->unique()->bothify(str_repeat('#', 10)),
            'contract_number'       => $this->faker->bothify(str_repeat('#', 10)),
            'postage_card'          => $this->faker->bothify(str_repeat('#', 10)),
            'administrative_number' => $this->faker->bothify(str_repeat('#', 10)),
            'posting_unit'          => $this->faker->bothify(str_repeat('#', 10)),
        ];
    }
}
