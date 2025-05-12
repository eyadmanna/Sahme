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

        $permissions = [
            'Land management' => [
                'Land Section View',
                'Land view',
                'Land create',
                'Land edit',
            ],
            'Projects management' => [
                'Projects Section View',
                'Projects view',
                'Projects create',
            ],
            'Engineering Partner Management' => [
                'Engineering Section View'
            ],
            'Contractor management' => [
                'Contractor Section View'
            ],
            'Settings' => [
                'Settings Section View',
                'users view',
                'user view',
                'user create',
                'user edit',
                'user delete',
                'roles view',
                'roles view',
                'role view',
                'role create',
                'role edit',
            ],
            'Reports' => [
                'Reports Section View'
            ]
        ];

        foreach ($permissions as $group => $actions) {
            foreach ($actions as $name) {
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group' => $group]
                );
            }
        }



        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $editorRole = Role::firstOrCreate(['name' => 'المثمن العقاري']);
        $editorRole->syncPermissions(['user view', 'user create']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }

}
