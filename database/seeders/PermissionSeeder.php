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
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create properties']);
        Permission::create(['name' => 'list properties']);
        Permission::create(['name' => 'update properties']);
        Permission::create(['name' => 'delete properties']);
        Permission::create(['name' => 'view properties analytics']);
        Permission::create(['name' => 'create applications']);
        Permission::create(['name' => 'update applications']);
        Permission::create(['name' => 'list applications']);
        Permission::create(['name' => 'view application']);
        Permission::create(['name' => 'delete applications']);
        Permission::create(['name' => 'change applications status']);
        Permission::create(['name' => 'create tenants']);
        Permission::create(['name' => 'update tenants']);
        Permission::create(['name' => 'list tenants']);
        Permission::create(['name' => 'view tenant']);
        Permission::create(['name' => 'delete tenants']);
        Permission::create(['name' => 'search tenants']);
        Permission::create(['name' => 'create lease agreements']);
        Permission::create(['name' => 'list lease agreements']);
        Permission::create(['name' => 'update lease agreements']);
        Permission::create(['name' => 'delete lease agreements']);
        Permission::create(['name' => 'view lease agreement']);
        Permission::create(['name' => 'sign lease agreement']);
        Permission::create(['name' => 'terminate lease agreement']);
        Permission::create(['name' => 'change lease agreements status']);
        Permission::create(['name' => 'create reviews']);
        Permission::create(['name' => 'delete reviews']);
        Permission::create(['name' => 'create maintenance requests']);
        Permission::create(['name' => 'list maintenance requests']);
        Permission::create(['name' => 'update maintenance requests']);
        Permission::create(['name' => 'delete maintenance requests']);
        Permission::create(['name' => 'view maintenance request']);
        Permission::create(['name' => 'change maintenance requests status']);
        
        // Owner role with permissions
        Role::create(['name' => 'owner'])
            ->syncPermissions([
                // Properties
                'create properties', 
                'list properties',
                'update properties',
                'delete properties',  
                'view properties analytics',

                // Applications
                'change applications status',

                // Tenants
                'list tenants',
                'view tenant',
                'search tenants',

                // Lease agreements
                'create lease agreements',
                'list lease agreements',
                'update lease agreements',
                'delete lease agreements',
                'view lease agreement',
                'terminate lease agreement',

                // Reviews
                'create reviews',
            ]);


        // Tenant role with permissions
        Role::create(['name' => 'tenant'])
            ->syncPermissions([
                // Tenants
                'create tenants',
                'update tenants',

                // Applications
                'create applications',
                'update applications',
                'delete applications',
                'view application',

                // Lease agreements
                'sign lease agreement',

                // Maintenance requests
                'create maintenance requests',
                'list maintenance requests',
                'view maintenance request',
                'delete maintenance requests',
                'change maintenance requests status',

                // Reviews
                'create reviews',
            ]);

        // Agent role with permissions
        Role::create(['name' => 'agent'])
            ->syncPermissions([
                'create properties',
                'update properties',
                'delete properties',
                'view properties analytics',
                'view tenant',
                'change applications status',
                'sign lease agreement',
                'change maintenance requests status',
                'create reviews',
            ]);

        // Lawyer role with permissions
        Role::create(['name' => 'lawyer'])
            ->syncPermissions([
                'view lease agreement',
                'sign lease agreement',
                'change lease agreements status'
            ]);

        // Admin role with permissions
        Role::create(['name' => 'admin'])
            ->syncPermissions([
                'delete users',
                'delete tenants',
                'delete reviews'
            ]);
    }
}
