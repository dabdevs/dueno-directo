<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PropertyPreference;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            // Admin test user
            User::factory()->create([
                'email' => 'admin@duenodirecto.com',
                'family_name' => 'James',
                'given_name' => 'Steven J. K.',
                'role' => 'admin'
            ])->syncRoles(['admin', 'owner', 'tenant', 'lawyer', 'agent']);

            // Owner test user
            User::factory()->create([
                'email' => 'owner@duenodirecto.com',
                'family_name' => 'Morrison',
                'given_name' => 'Jackie',
                'role' => 'owner'
            ])->assignRole('owner');

            // Tenant test user
            $user = User::factory()->create([
                'email' => 'tenant@duenodirecto.com',
                'family_name' => 'Pierre',
                'given_name' => 'Martine',
                'role' => 'tenant'
            ])->assignRole('tenant');

            PropertyPreference::factory()->create(['user_id' => $user->id, 'occupation' => ['Doctor']]);

            // Agent test user
            User::factory()->create([
                'email' => 'agent@duenodirecto.com',
                'family_name' => 'Lommert',
                'given_name' => 'Karla G.',
                'role' => 'agent'
            ])->assignRole('agent');

            // Lawyer test user
            User::factory()->create([
                'email' => 'lawyer@duenodirecto.com',
                'family_name' => 'Bifuka',
                'given_name' => 'Darla Stephie G.',
                'role' => 'lawyer'
            ])->assignRole('lawyer');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
