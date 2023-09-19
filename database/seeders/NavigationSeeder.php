<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Navigation::create([
                'name' => 'Properties',
                'endpoint' => '/properties',
                'allowed_roles' => ['owner', 'admin']
            ]);

            Navigation::create([
                'name' => 'Tenants',
                'endpoint' => '/tenants',
                'allowed_roles' => ['tenant', 'admin']
            ]);

            Navigation::create([
                'name' => 'Verification Requests',
                'endpoint' => '/verification-requests',
                'allowed_roles' => ['admin']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
