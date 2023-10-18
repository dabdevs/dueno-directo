<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PropertyApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $properties = User::whereEmail('owner@duenodirecto.com')->first()->properties;
            $user = User::whereEmail('renter@duenodirecto.com')->first();

            foreach ($properties as $property) {
                $property->applications()->create([
                    'user_id' => $user->id,
                    'note' => 'Default note to owner.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
