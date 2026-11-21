<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Semen & Perekat', 'slug' => 'semen-perekat', 'sim_type' => 'none', 'sim_units_per_pack' => 1],
            ['name' => 'Batu & Pasir', 'slug' => 'batu-pasir', 'sim_type' => 'volume', 'sim_coverage' => 1.0000, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['name' => 'Bata & Batako', 'slug' => 'bata-batako', 'sim_type' => 'area', 'sim_coverage' => 0.0625, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['name' => 'Keramik & Granit', 'slug' => 'keramik-granit', 'sim_type' => 'area', 'sim_coverage' => 0.04, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 10, 'sim_rounding' => 'ceil'],
            ['name' => 'Cat & Pelapis', 'slug' => 'cat-pelapis', 'sim_type' => 'area', 'sim_coverage' => 10.0000, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['name' => 'Besi & Baja', 'slug' => 'besi-baja', 'sim_type' => 'weight', 'sim_coverage' => 1.0000, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 3, 'sim_rounding' => 'ceil'],
            ['name' => 'Kayu & Multiplek', 'slug' => 'kayu-multiplek', 'sim_type' => 'area', 'sim_coverage' => 2.88, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 8, 'sim_rounding' => 'ceil'],
            ['name' => 'Genteng & Atap', 'slug' => 'genteng-atap', 'sim_type' => 'area', 'sim_coverage' => 0.25, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 10, 'sim_rounding' => 'ceil'],
            ['name' => 'Pipa & Fitting', 'slug' => 'pipa-fitting', 'sim_type' => 'count', 'sim_units_per_pack' => 1],
            ['name' => 'Listrik & Lampu', 'slug' => 'listrik-lampu', 'sim_type' => 'count', 'sim_units_per_pack' => 1],
        ];

        foreach ($categories as $c) {
            Category::create(array_merge(['sim_units_per_pack' => 1, 'sim_waste_percent' => 0, 'sim_rounding' => 'ceil'], $c));
        }
    }
}