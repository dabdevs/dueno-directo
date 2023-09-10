<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create(['role' => 'tenant'])->id;
            },
            'occupation' => $this->faker->randomElement(['student', 'doctor', 'engineer', 'athelete', 'musician', 'salesman', 'architect', 'lawyer', 'businessman', 'constructor']),
            'income' => $this->faker->numberBetween(100000, 300000),
            'desired_location' => $this->faker->randomElement(['Buenos Aires', 'Los Angeles', 'Santiago', 'New York', 'Chicago', 'Boston', 'Lima', 'Montevideo', 'Madrid', 'Paris']),
            'number_of_occupants' => $this->faker->numberBetween(1, 5),
            'has_pets' => $this->faker->randomElement([0, 1]),
            'smoker' => $this->faker->randomElement([0, 1]),
            'employment_status' => $this->faker->randomElement(['employed', 'self-employed', 'unemployed']),
            'additional_note' => $this->faker->paragraph()
        ];
    }
}