<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\LMS\Models\Auth\Admin;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Academine',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '+1406-558-4308',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $admin->assignRole('Super Admin');
    }
}
