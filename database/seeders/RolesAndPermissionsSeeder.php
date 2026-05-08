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
        Permission::create(['name' => 'manage cars']);
        Permission::create(['name' => 'manage brands']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view cars']);

        // Create roles and assign created permissions
        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo(['view cars', 'manage cars']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('view cars');
    }
}
