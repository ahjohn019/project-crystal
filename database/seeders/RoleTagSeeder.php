<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $accessSuperAdminPermissions = Permission::updateOrCreate(['name' => 'access_super_admin_settings']);
        $accessAdminPermissions = Permission::updateOrCreate(['name' => 'access_admin_settings']);
        $accessUserPermissions = Permission::updateOrCreate(['name' => 'access_user_settings']);

        $superAdminRole = Role::updateOrCreate(['name' => 'superadmin']);
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $userRole = Role::updateOrCreate(['name' => 'user']);

        $superAdminRole->givePermissionTo($accessSuperAdminPermissions);
        $adminRole->givePermissionTo($accessAdminPermissions);
        $userRole->givePermissionTo($accessUserPermissions);
    }
}
