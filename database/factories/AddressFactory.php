<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_ids = range(1, 20);

        // Shuffle the array to randomize the order
        shuffle($user_ids);

        // Use array_shift to get the numbers one by one without repeating
        $id = array_shift($user_ids);

        return [
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $id,
        ];
    }
}
