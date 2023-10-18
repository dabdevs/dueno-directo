<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\User;
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
            Navigation::create(
                [
                    'name' => 'Properties',
                    'endpoint' => 'api/v1/owners/properties',
                    'allowed_roles' => [User::ROLE_OWNER]
                ],
                [
                    'name' => 'Property applications',
                    'endpoint' => 'api/v1/owners/properties/applications',
                    'allowed_roles' => [User::ROLE_OWNER]
                ],
                [
                    'name' => 'Property Applications',
                    'endpoint' => '/property-applications',
                    'allowed_roles' => [User::ROLE_OWNER]
                ],
                [
                    'name' => 'Renters',
                    'endpoint' => '/renters',
                    'allowed_roles' => [User::ROLE_ADMIN]
                ],
                [
                    'name' => 'Tenants',
                    'endpoint' => '/tenants',
                    'allowed_roles' => [User::ROLE_ADMIN]
                ],
                [
                    'name' => 'Verification Requests',
                    'endpoint' => '/verification-requests',
                    'allowed_roles' => [User::ROLE_ADMIN]
                ]
            );
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
