<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::factory()
        ->count(10)
        ->hasApplications(10)
        ->create();

        Tenant::factory()
        ->count(10)
        ->hasApplications(4)
        ->create();

        Tenant::factory()
        ->count(10)
        ->create();
    }
}
