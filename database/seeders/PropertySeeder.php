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
            ->hasPreferences()
            ->hasApplications(20)
            ->create();

        Property::factory()
            ->count(10)
            ->hasOwner()
            ->hasPreferences()
            ->hasApplications(13)
            ->create();

        Property::factory()
            ->count(18)
            ->hasOwner()
            ->hasPreferences()
            ->hasTenant()
            ->hasApplications(22)
            ->create();
    }
}