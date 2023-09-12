<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleOwner = Role::create(['name' => 'owner']);
        $roleTenant = Role::create(['name' => 'tenant']);
        $roleAgent = Role::create(['name' => 'agent']);
        $roleLawyer = Role::create(['name' => 'lawyer']);
        $roleAdmin = Role::create(['name' => 'admin']); 

        // Properties permissions
        Permission::create(['name' => 'create properties'])->assignRole($roleOwner);
        Permission::create(['name' => 'list properties'])->assignRole($roleOwner);
        Permission::create(['name' => 'update properties'])->assignRole($roleOwner);
        Permission::create(['name' => 'delete properties'])->assignRole($roleOwner);
        Permission::create(['name' => 'view property analytics'])->assignRole($roleOwner);

        // Tenant permissions
        Permission::create(['name' => 'create tenants'])->assignRole($roleTenant);
        Permission::create(['name' => 'list tenants'])->assignRole($roleTenant);
        Permission::create(['name' => 'update tenants'])->assignRole($roleTenant);
        Permission::create(['name' => 'delete tenants'])->assignRole($roleTenant);

        // Verification request
        Permission::create(['name' => 'create verification requests'])->syncRoles([$roleTenant, $roleOwner]);
        Permission::create(['name' => 'update verification requests'])->syncRoles([$roleTenant, $roleOwner]);
        Permission::create(['name' => 'delete verification requests'])->syncRoles([$roleTenant, $roleOwner]);
        Permission::create(['name' => 'list verification requests'])->syncRoles([$roleTenant, $roleOwner, $roleAdmin]);

        // Lease Agreement
        Permission::create(['name' => 'create lease agreements'])->assignRole($roleOwner);
        Permission::create(['name' => 'list lease agreements'])->assignRole($roleOwner);
        Permission::create(['name' => 'update lease agreements'])->assignRole($roleOwner);
        Permission::create(['name' => 'delete lease agreements'])->assignRole($roleOwner);
        Permission::create(['name' => 'terminate lease agreements'])->assignRole($roleOwner);
        Permission::create(['name' => 'sign lease agreements'])->assignRole($roleOwner);

        // Maintenance Requests
        Permission::create(['name' => 'create maintenance requests'])->assignRole($roleTenant);
        Permission::create(['name' => 'list maintenance requests'])->assignRole($roleTenant);
        Permission::create(['name' => 'update maintenance requests'])->assignRole($roleTenant);
        Permission::create(['name' => 'delete maintenance requests'])->assignRole($roleTenant);
        Permission::create(['name' => 'change maintenance request status'])->assignRole($roleOwner);


        // Applications
        Permission::create(['name' => 'create applications'])->assignRole($roleTenant);
        Permission::create(['name' => 'update applications'])->assignRole($roleTenant);
        Permission::create(['name' => 'list applications'])->assignRole($roleTenant);
        Permission::create(['name' => 'delete applications'])->assignRole($roleTenant);
        Permission::create(['name' => 'change applications status'])->assignRole($roleOwner);
        Permission::create(['name' => 'accept applications'])->assignRole($roleOwner);
        Permission::create(['name' => 'reject applications'])->assignRole($roleOwner);

        // Reviews
        Permission::create(['name' => 'create reviews'])->syncRoles([$roleTenant, $roleOwner]);
        Permission::create(['name' => 'update reviews'])->assignRole($roleAdmin);
        Permission::create(['name' => 'delete reviews'])->assignRole($roleAdmin);

    }
}
