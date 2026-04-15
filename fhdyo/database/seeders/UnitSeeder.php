<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create default admin
        $admin = Admin::first();
        
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin123'),
            ]);
        }

        $units = [
            [
                'name' => 'Muloqot va Tushunish',
                'description' => 'Oilaviy munosabatlarda muloqot, eshitish va o\'zaro tushunish qobiliyatini baholash',
                'category' => 'nikoh',
            ],
            [
                'name' => 'Qadriyatlar va Hayotga Qarashlar',
                'description' => 'Hayotiy qadriyatlar, diniy va ma\'naviy qarashlar, oilaviy ustuvorliklarni aniqlash',
                'category' => 'nikoh',
            ],
            [
                'name' => 'Moliyaviy Yondashuv',
                'description' => 'Pul boshqaruvi, moliyaviy rejalar va tejamkorlik haqidagi qarashlarni baholash',
                'category' => 'nikoh',
            ],
            [
                'name' => 'Hissiy Barqarorlik',
                'description' => 'Stress boshqaruvi, hissiy muvozanat va ruhiy mustahkamlikni aniqlash',
                'category' => 'nikoh',
            ],
            [
                'name' => 'Farzand Tarbigasi va Oilaviy Mas\'uliyat',
                'description' => 'Bolalar tarbiyasi, oilaviy mas\'uliyat va ota-ona vazifalarini baholash',
                'category' => 'nikoh',
            ],
        ];

        foreach ($units as $unit) {
            Unit::create([
                'admin_id' => $admin->id,
                'name' => $unit['name'],
                'description' => $unit['description'],
                'category' => $unit['category'],
            ]);
        }
    }
}
