<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
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
            'property_id' => \App\Models\Property::factory()->create()->id, 
            'tenant_id' => \App\Models\Tenant::factory()->create()->id
        ];
    }
}
