<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->
        forgetCachedPermissions();

        Role::create(['name' => 'Employee']);
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Admin']);
    }
}
