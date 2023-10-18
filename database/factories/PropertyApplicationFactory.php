<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => $this->faker->paragraph(),
            'property_id' => $this->faker->numberBetween(1, 5),
            'user_id' => User::whereEmail('renter@duenodirecto.com')->first()->id
        ];
    }
}
