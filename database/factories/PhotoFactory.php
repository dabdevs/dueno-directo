<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' => 'https://dummyimage.com/600x400/b2b2b2/000.jpg',
            'type' => 'property'
        ];
    }
}
