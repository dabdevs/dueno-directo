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
                'family_name' => 'Admin',
                'given_name' => 'Admin',
                'role' => User::ROLE_ADMIN
            ])->syncRoles([User::ROLE_ADMIN, User::ROLE_RENTER, User::ROLE_OWNER, User::ROLE_TENANT, User::ROLE_LAWYER, User::ROLE_AGENT]);

            // Renter test user
            // User::factory()->create([
            //     'email' => 'renter@duenodirecto.com',
            //     'family_name' => 'Renter',
            //     'given_name' => 'Renter',
            //     'role' => User::ROLE_RENTER
            // ])->assignRole(User::ROLE_RENTER);

            // Owner test user
            User::factory()->create([
                'email' => 'owner@duenodirecto.com',
                'family_name' => 'Owner',
                'given_name' => 'Owner',
                'role' => User::ROLE_OWNER
            ])->assignRole(User::ROLE_OWNER);

            // Tenant test user
            $user = User::factory()->create([
                'email' => 'tenant@duenodirecto.com',
                'family_name' => 'Tenant',
                'given_name' => 'Tenant',
                'role' => User::ROLE_TENANT
            ])->assignRole(User::ROLE_TENANT);

            PropertyPreference::factory()->create(['user_id' => $user->id, 'occupation' => ['Doctor']]);

            // Agent test user
            User::factory()->create([
                'email' => 'agent@duenodirecto.com',
                'family_name' => 'Agent',
                'given_name' => 'Agent',
                'role' => User::ROLE_AGENT
            ])->assignRole(User::ROLE_AGENT);

            // Lawyer test user
            User::factory()->create([
                'email' => 'lawyer@duenodirecto.com',
                'family_name' => 'Lawyer',
                'given_name' => 'Lawyer',
                'role' => User::ROLE_LAWYER
            ])->assignRole(User::ROLE_LAWYER);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
