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

        // Properties 
        Permission::create(['name' => 'create properties'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'list properties'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'update properties'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'delete properties'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'view property analytics'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);

        // Tenant 
        Permission::create(['name' => 'create tenants'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'list tenants'])->assignRole($roleAdmin);
        Permission::create(['name' => 'update tenants'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'delete tenants'])->assignRole($roleAdmin);
        Permission::create(['name' => 'view tenant'])->syncRoles([$roleOwner, $roleAgent, $roleLawyer, $roleAdmin]);
        Permission::create(['name' => 'search tenants'])->syncRoles([$roleOwner, $roleAgent, $roleLawyer, $roleAdmin]);

        // Verification request
        Permission::create(['name' => 'change verification requests status'])->assignRole($roleAdmin);

        // Lease Agreement
        Permission::create(['name' => 'create lease agreements'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'list lease agreements'])->syncRoles([$roleLawyer, $roleOwner, $roleAdmin]);
        Permission::create(['name' => 'update lease agreements'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'delete lease agreements'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'view lease agreement'])->syncRoles([$roleLawyer, $roleTenant, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'terminate lease agreements'])->syncRoles([$roleOwner, $roleLawyer, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'sign lease agreements'])->syncRoles([$roleOwner, $roleAgent, $roleTenant]);

        // Maintenance Requests
        Permission::create(['name' => 'create maintenance requests'])->assignRole($roleTenant);
        Permission::create(['name' => 'list maintenance requests'])->assignRole($roleAdmin);
        Permission::create(['name' => 'update maintenance requests'])->syncRoles([$roleOwner, $roleTenant, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'delete maintenance requests'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'change maintenance request status'])->syncRoles([$roleOwner, $roleTenant, $roleAgent, $roleAdmin]);


        // Applications
        Permission::create(['name' => 'create applications'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'update applications'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'list applications'])->syncRoles([$roleTenant, $roleOwner, $roleAgent, $roleAdmin]);
        Permission::create(['name' => 'delete applications'])->syncRoles([$roleTenant, $roleAdmin]);
        Permission::create(['name' => 'change applications status'])->syncRoles([$roleOwner, $roleAgent, $roleAdmin]);

        // Reviews
        Permission::create(['name' => 'create reviews'])->syncRoles([$roleTenant, $roleOwner]);
        Permission::create(['name' => 'update reviews'])->assignRole($roleAdmin);
        Permission::create(['name' => 'delete reviews'])->assignRole($roleAdmin);

    }
}
