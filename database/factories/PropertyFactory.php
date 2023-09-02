<?php

namespace Database\Factories;

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
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'area' => $this->faker->numberBetween(500, 5000),
            'location' => $this->faker->city,
            'phone_number' => $this->faker->phoneNumber,
            'property_type' => $this->faker->randomElement(['House', 'Apartment', 'Condo']),
            'property_address' => $this->faker->address,
            'property_description' => $this->faker->paragraph,
            'rental_price' => $this->faker->randomFloat(2, 500, 5000),
            'lease_term' => $this->faker->randomElement(['1 Year', '6 Months', 'Month-to-Month']),
            'availability' => $this->faker->randomElement(['Available', 'Not Available']),
            'rent_payment_method' => $this->faker->randomElement(['Credit Card', 'Bank Transfer']),
            'security_deposit' => $this->faker->randomFloat(2, 100, 1000),
            'rental_agreement' => $this->faker->text,
            'preferred_tenant_profile' => $this->faker->text,
            'additional_note' => $this->faker->paragraph,
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
