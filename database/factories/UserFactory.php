<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roles = ['owner', 'tenant'];
        $role = $roles[array_rand($roles)];
        $countries = Country::all()->pluck('id');

        return [
            'given_name' => $this->faker->firstName(),
            'family_name' => $this->faker->lastName(),
            'role' => $role,
            'telephone' => $this->faker->phoneNumber(),
            'country_id' => $this->faker->randomElement($countries),
            'city' => $this->faker->randomElement(['Buenos Aires', 'Los Angeles', 'Santiago', 'New York', 'Chicago', 'Boston', 'Lima', 'Montevideo', 'Madrid', 'Paris']),
            'number' => $this->faker->numberBetween(1, 1000),
            'appartment' => $this->faker->randomNumber(),
            'zip_code' => $this->faker->numberBetween(1000, 9999), 
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('1234'), 
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
