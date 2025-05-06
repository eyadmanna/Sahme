<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(
            ['name' => 'user view', 'guard_name' => 'web'],
            ['group' => 'Settings']
        );
        Permission::firstOrCreate(
            ['name' => 'user create', 'guard_name' => 'web'],
            ['group' => 'Settings']
        );
        Permission::firstOrCreate(
            ['name' => 'user edit', 'guard_name' => 'web'],
            ['group' => 'Settings']
        );
        Permission::firstOrCreate(
            ['name' => 'user delete', 'guard_name' => 'web'],
            ['group' => 'Settings']
        );
        Permission::firstOrCreate(
            ['name' => 'Land view', 'guard_name' => 'web'],
            ['group' => 'Land management']
        );
        Permission::firstOrCreate(
            ['name' => 'Land create', 'guard_name' => 'web'],
            ['group' => 'Land management']
        );
        Permission::firstOrCreate(
            ['name' => 'Land edit', 'guard_name' => 'web'],
            ['group' => 'Land management']
        );
        Permission::firstOrCreate(
            ['name' => 'Projects view', 'guard_name' => 'web'],
            ['group' => 'Projects management']
        );
        Permission::firstOrCreate(
            ['name' => 'Projects create', 'guard_name' => 'web'],
            ['group' => 'Projects management']
        );



        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $editorRole = Role::firstOrCreate(['name' => 'المثمن العقاري']);
        $editorRole->syncPermissions(['user view', 'user create']);

        $viewerRole = Role::firstOrCreate(['name' => 'مستثمر']);
        $viewerRole->syncPermissions(['user view']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }

}
