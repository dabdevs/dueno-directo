<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::factory()
            ->count(10)
            ->hasOwner()
            ->hasPreferences()
            ->hasApplications(1)
            ->create();

        Property::factory()
        ->count(10)
        ->hasOwner()
        ->hasPreferences()
        ->hasApplications(5)
        ->create();

        Property::factory()
            ->count(10)
            ->hasOwner()
            ->hasRequirements(1)
            ->hasPreferences()
            ->hasApplications(20)
            ->create();

        Property::factory()
            ->count(10)
            ->hasOwner()
            ->hasPreferences()
            ->hasApplications(5)
            ->create();

        Property::factory()
            ->count(10)
            ->hasOwner()
            ->hasPreferences()
            ->hasTenant()
            ->hasRequirements(3)
            ->hasApplications(12)
            ->create();

        Property::factory()
            ->count(3)
            ->hasOwner()
            ->hasTenant()
            ->hasPreferences()
            ->create();
    }
}
