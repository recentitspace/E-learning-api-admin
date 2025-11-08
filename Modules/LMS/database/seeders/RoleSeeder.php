<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [

            [
                'name' => 'Admin',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'Student',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Instructor',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Organization',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
