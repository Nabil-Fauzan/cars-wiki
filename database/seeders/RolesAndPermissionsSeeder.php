<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $p1 = Permission::create(['name' => 'manage cars']);
        $p2 = Permission::create(['name' => 'manage brands']);
        $p3 = Permission::create(['name' => 'manage users']);
        $p4 = Permission::create(['name' => 'view cars']);

        // Create roles and assign created permissions
        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo([$p1, $p4]);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo($p4);
    }
}
