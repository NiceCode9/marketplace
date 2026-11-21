<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Holcim', 'Semen Gresik', 'Tiga Roda', 'Jayamix', 'Wavin', 'Maspion', 'Nippon Paint', 'Dulux', 'Mulia', 'Roman'] as $name) {
            Brand::create(['name' => $name, 'slug' => str($name)->slug()]);
        }
    }
}