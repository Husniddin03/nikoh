<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SurveySeeder::class,
        ]);

        // Create a default admin user
        User::factory()->create([
            'name' => 'Shaxobiddin Jovliyev',
            'jshshir' => '12345678012340',
            'passport_id' => 'AD1234510',
            'phone' => '90 030 10 03',
            'email' => 'shaxobiddin@gmail.com',
            'region' => 'Toshkent',
            'district' => 'Bektemir',
            'role' => 'super_admin',
            'password' => bcrypt('password')
        ]);
    }
}
