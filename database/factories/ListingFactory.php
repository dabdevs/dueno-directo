<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'phone_number' => $this->faker->phoneNumber,
            'property_address' => $this->faker->address,
            'property_type' => $this->faker->randomElement(['apartment', 'house', 'condo']),
            'property_description' => $this->faker->paragraph,
            'rental_price' => $this->faker->randomFloat(2, 500, 5000),
            'lease_term' => $this->faker->randomElement(['monthly', 'quarterly', 'yearly']),
            'availability' => $this->faker->date(),
            'rent_payment_method' => $this->faker->randomElement(['bank_transfer', 'check', 'cash']),
            'security_deposit' => $this->faker->randomFloat(2, 100, 1000),
            'rental_agreement' => $this->faker->text,
            'preferred_tenant_profile' => $this->faker->sentence,
            'additional_note' => $this->faker->paragraph,
        ];
    }
}
