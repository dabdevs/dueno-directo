<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Owner role
        Role::create(['name' => User::ROLE_OWNER]);

        // Renter role
        Role::create(['name' => User::ROLE_RENTER]);

        // Tenant role
        Role::create(['name' => User::ROLE_TENANT]);

        // Agent role
        Role::create(['name' => User::ROLE_AGENT]);

        // Lawyer role
        Role::create(['name' => User::ROLE_LAWYER]);

        // Admin role
        Role::create(['name' => User::ROLE_ADMIN]);
    }
}
