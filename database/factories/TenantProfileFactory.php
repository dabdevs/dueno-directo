<?php

namespace Database\Factories;

use App\Models\TenantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantProfileFactory extends Factory
{
    protected $model = TenantProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(11, 20),
            'occupation' => $this->faker->jobTitle,
            'income' => $this->faker->randomFloat(2, 1000, 10000),
            'desired_location' => $this->faker->address, 
            'number_of_occupants' => $this->faker->numberBetween(1, 5), 
            'has_pets' => $this->faker->boolean, 
            'smoker' => $this->faker->boolean, 
            'employment_status' => $this->faker->randomElement(['employed', 'unemployed', 'student']),
            'additional_criteria' => $this->faker->paragraph, 
            'additional_notes' => $this->faker->paragraph, 
        ];
    }
}
