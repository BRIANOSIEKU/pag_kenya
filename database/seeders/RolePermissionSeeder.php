<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // SUPER ADMIN → everything
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(Permission::all());

        // GENERAL SUPERINTENDENT → transfers only
        $superintendent = Role::findByName('general_superintendent');
        $superintendent->givePermissionTo([
            'approve transfers',
            'view district module dashboard',
        ]);

        // GENERAL SECRETARY → reports + dashboard
        $secretary = Role::findByName('general_secretary');
        $secretary->givePermissionTo([
            'approve tithe reports',
            'view district module dashboard',
        ]);

        // GENERAL TREASURER → financial control (optional future expansion)
        $treasurer = Role::findByName('general_treasurer');
        $treasurer->givePermissionTo([
            'approve tithe reports',
            'view district module dashboard',
        ]);

        // ADMIN → system management only
        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'manage users',
            'view district module dashboard',
        ]);
    }
}