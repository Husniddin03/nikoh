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
            AdminSeeder::class,
            UnitSeeder::class,
            QuestionSeeder::class,
            AjrimSeeder::class,
            RealDataSeeder::class, // Real users with JSHSHIR and test data for Jan-Apr 2026
        ]);
    }
}
