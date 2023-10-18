<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'title' => $title,
            'slug' => str_replace('', '-', $title),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'area' => $this->faker->numberBetween(500, 5000),
            'telephone' => $this->faker->phoneNumber,
            'type' => $this->faker->randomElement(['House', 'Apartment', 'Condo']),
            'user_id' => User::whereRole(User::ROLE_OWNER)->first()->id,
            'agent_id' => $this->faker->randomElement([null, User::factory()->create(['role' => 'agent'])->id]),
            'country_id' => $this->faker->randomElement([1, 3]),
            'city_id' => $this->faker->randomElement([1, 3])
        ];
    }
}
