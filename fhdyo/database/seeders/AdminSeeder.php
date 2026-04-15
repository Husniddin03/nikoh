<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'is_super_admin' => false,
            ]
        );

        // Create additional admins
        Admin::updateOrCreate(
            ['username' => 'super'],
            [
                'name' => 'Super Admin',
                'username' => 'super',
                'password' => Hash::make('super123'),
                'is_super_admin' => true,
            ]
        );
    }
}
