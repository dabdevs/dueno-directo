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
            ->count(2)
            ->hasOwner()
            ->hasPreferences()
            ->hasApplications(1)
            ->hasPhotos(5)
            ->create();

        Property::factory()
        ->count(1)
        ->hasOwner()
        ->hasPreferences()
        ->hasApplications(5)
        ->hasPhotos(2)
        ->create();

        Property::factory()
            ->count(3)
            ->hasOwner()
            ->hasRequirements(1)
            ->hasPreferences()
            ->hasApplications(7)
            ->hasPhotos(6)
            ->create();

        Property::factory()
            ->count(2)
            ->hasOwner()
            ->hasPreferences()
            ->hasApplications(2)
            ->hasPhotos(3)
            ->create();

        Property::factory()
            ->count(4)
            ->hasOwner()
            ->hasPreferences()
            ->hasTenant()
            ->hasRequirements(3)
            ->hasApplications(12)
            ->hasPhotos(5)
            ->create();

        Property::factory()
            ->count(3)
            ->hasOwner()
            ->hasTenant()
            ->hasRequirements(5)
            ->hasPreferences()
            ->hasPhotos(2)
            ->create();
    }
}
