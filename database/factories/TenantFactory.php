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
            'user_id' => \App\Models\User::factory()->create(['role' => 'tenant'])->id,
            'occupation' => $this->faker->randomElement(['Student', 'Doctor', 'Engineer', 'Athelete', 'Musician', 'Salesman', 'Architect', 'Lawyer', 'Businessman', 'Constructor']),
            'income' => $this->faker->numberBetween(100000, 300000),
            'number_of_occupants' => $this->faker->numberBetween(1, 5),
            'has_pets' => $this->faker->randomElement([0, 1]),
            'smoker' => $this->faker->randomElement([0, 1]),
            'employment_status' => $this->faker->randomElement(['Employed', 'Self-Employed', 'Unemployed']),
            'note' => $this->faker->paragraph()
        ];
    }
}
