<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Owners
        User::factory() 
        ->count(15)
        ->hasProperties(1)
        ->create(['role' => 'owner']);

        User::factory()
        ->count(5)
        ->hasProperties(2)
        ->create(['role' => 'owner']);

        User::factory()
        ->count(6)
        ->hasProperties(3)
        ->create(['role' => 'owner']);

        User::factory()
        ->count(4)
        ->hasProperties(4)
        ->create(['role' => 'owner']);

        // Tenants
        User::factory()
        ->count(20)
        ->hasTenant(1)
        ->create(['role' => 'tenant']);

        User::factory()
        ->count(10)
        ->hasTenant(1)
        ->create(['role' => 'tenant']);

        User::factory()
        ->count(13)
        ->hasTenant(1)
        ->create(['role' => 'tenant']);
    }
}
