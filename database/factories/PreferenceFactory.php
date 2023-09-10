<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_id' => function () {
                return \App\Models\Property::factory()->create()->id;
            },
            'occupation' => $this->faker->randomElement(['student', 'doctor', 'engineer', 'athelete', 'musician', 'salesman', 'architect', 'lawyer', 'businessman', 'constructor']),
            'min_income' => $this->faker->numberBetween(10000, 20000),
            'max_income' => $this->faker->numberBetween(100000, 500000),
            'number_of_occupants' => $this->faker->numberBetween(1, 5),
            'has_pets' => $this->faker->randomElement([0, 1]),
            'smoker' => $this->faker->randomElement([0, 1]),
            'employment_status' =>  $this->faker->randomElement(['employed', 'self-employed', 'unemployed']),
        ];
    }
}
