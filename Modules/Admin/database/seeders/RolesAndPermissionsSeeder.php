<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions (examples)
        Permission::create(['name' => 'create lesson plans']);
        Permission::create(['name' => 'edit lesson plans']);
        Permission::create(['name' => 'delete lesson plans']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'Professor Free']);
        $role->givePermissionTo('create lesson plans');

        // or may be done by chaining
        $role = Role::create(['name' => 'Professor Pro'])
            ->givePermissionTo(['create lesson plans', 'edit lesson plans']);

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());
    }
}
