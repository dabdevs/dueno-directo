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
            Navigation::create([
                'name' => 'Properties',
                'endpoint' => 'api/v1/owners/properties',
                'allowed_roles' => [User::ROLE_OWNER, User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Favorite Renters',
                'endpoint' => 'api/v1/owners/favorite-renters',
                'allowed_roles' => [User::ROLE_OWNER, User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Favorite Properties',
                'endpoint' => 'api/v1/renters/favorite-properties',
                'allowed_roles' => [User::ROLE_RENTER, User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Applications',
                'endpoint' => 'api/v1/owners/properties/{property}/applications',
                'allowed_roles' => [User::ROLE_OWNER, User::ROLE_RENTER, User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Owners',
                'endpoint' => 'api/v1/admin/owners',
                'allowed_roles' => [User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Renters',
                'endpoint' => 'api/v1/admin/renters',
                'allowed_roles' => [User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Tenants',
                'endpoint' => 'api/v1/admin/tenants',
                'allowed_roles' => [User::ROLE_ADMIN]
            ]);

            Navigation::create([
                'name' => 'Verification Requests',
                'endpoint' => 'api/v1/admin/verification-requests',
                'allowed_roles' => [User::ROLE_ADMIN]
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
