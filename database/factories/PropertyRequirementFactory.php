<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyRequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_id' => $this->faker->numberBetween(1, 20),
            'name'  => $this->faker->randomElement(['Months deposit', 'Criminal records', 'Bank records']),
            'quantity' => 1,
            'note' => $this->faker->paragraph(1)
        ];
    }
}
