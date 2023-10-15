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
                'role' => User::ROLE_ADMIN
            ])->syncRoles([User::ROLE_ADMIN, User::ROLE_OWNER, User::ROLE_TENANT, User::ROLE_LAWYER, User::ROLE_AGENT]);

            // Owner test user
            User::factory()->create([
                'email' => 'owner@duenodirecto.com',
                'family_name' => 'Morrison',
                'given_name' => 'Jackie',
                'role' => User::ROLE_OWNER
            ])->assignRole(User::ROLE_OWNER);

            // Tenant test user
            $user = User::factory()->create([
                'email' => 'tenant@duenodirecto.com',
                'family_name' => 'Pierre',
                'given_name' => 'Martine',
                'role' => User::ROLE_TENANT
            ])->assignRole(User::ROLE_TENANT);

            PropertyPreference::factory()->create(['user_id' => $user->id, 'occupation' => ['Doctor']]);

            // Agent test user
            User::factory()->create([
                'email' => 'agent@duenodirecto.com',
                'family_name' => 'Lommert',
                'given_name' => 'Karla G.',
                'role' => User::ROLE_AGENT
            ])->assignRole(User::ROLE_AGENT);

            // Lawyer test user
            User::factory()->create([
                'email' => 'lawyer@duenodirecto.com',
                'family_name' => 'Bifuka',
                'given_name' => 'Darla Stephie G.',
                'role' => User::ROLE_LAWYER
            ])->assignRole(User::ROLE_LAWYER);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
