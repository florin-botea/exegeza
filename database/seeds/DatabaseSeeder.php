<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    private $role_permissions = [
        'developer' => [
            'manage bibles',
            'publish articles',
            'create articles',
            'update users',
        ],
        'admin' => [
            'manage bibles',
            'publish articles',
            'create articles',
            'update users',
        ],
        'user' => [
            'create articles',
        ],
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->role_permissions as $role => $permissions) {
            $role = Role::firstOrCreate(['name'=>$role]);
            foreach ($permissions as $permission) {
                $permission = Permission::firstOrCreate(['name'=>$permission]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
