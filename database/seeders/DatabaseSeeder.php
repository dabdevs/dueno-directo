<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(NavigationSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PropertySeeder::class);
        // $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
