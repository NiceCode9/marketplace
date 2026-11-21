<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $slug) => Category::where('slug', $slug)->firstOrFail()->id;
        $brand = fn (string $name) => Brand::where('name', $name)->firstOrFail()->id;

        $products = [
            ['category' => 'semen-perekat', 'brand' => 'Holcim', 'sku' => 'SMN-HLC-50', 'name' => 'Semen Holcim 50 kg', 'price' => 65000, 'stock' => 200, 'unit' => 'sak', 'status' => 'active', 'sim_type' => null],
            ['category' => 'batu-pasir', 'brand' => 'Jayamix', 'sku' => 'PSR-BNG-1M3', 'name' => 'Pasir Bangka 1 m3', 'price' => 350000, 'stock' => 50, 'unit' => 'm3', 'status' => 'active', 'sim_type' => 'volume', 'sim_coverage' => 1, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['category' => 'bata-batako', 'brand' => null, 'sku' => 'BTK-STD', 'name' => 'Batako Press Standard', 'price' => 4500, 'stock' => 5000, 'unit' => 'pcs', 'status' => 'active', 'sim_type' => 'area', 'sim_coverage' => 0.0625, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['category' => 'keramik-granit', 'brand' => 'Mulia', 'sku' => 'KRM-40x40', 'name' => 'Keramik Mulia 40x40', 'price' => 55000, 'stock' => 1000, 'unit' => 'dus', 'status' => 'active', 'sim_type' => 'area', 'sim_coverage' => 1.28, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 10, 'sim_rounding' => 'ceil'],
            ['category' => 'cat-pelapis', 'brand' => 'Nippon Paint', 'sku' => 'CAT-5L', 'name' => 'Cat Tembok Nippon 5L', 'price' => 285000, 'stock' => 80, 'unit' => 'pail', 'status' => 'active', 'sim_type' => 'area', 'sim_coverage' => 35, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 5, 'sim_rounding' => 'ceil'],
            ['category' => 'besi-baja', 'brand' => null, 'sku' => 'BESI-10', 'name' => 'Besi Beton 10mm (per batang)', 'price' => 85000, 'stock' => 300, 'unit' => 'batang', 'status' => 'active', 'sim_type' => 'weight', 'sim_coverage' => 1, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 3, 'sim_rounding' => 'ceil'],
            ['category' => 'kayu-multiplek', 'brand' => null, 'sku' => 'MLP-18', 'name' => 'Multiplek 18mm', 'price' => 185000, 'stock' => 60, 'unit' => 'lembar', 'status' => 'active', 'sim_type' => 'area', 'sim_coverage' => 2.88, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 8, 'sim_rounding' => 'ceil'],
            ['category' => 'genteng-atap', 'brand' => null, 'sku' => 'GTG-FLAT', 'name' => 'Genteng Flat Beton', 'price' => 12000, 'stock' => 2000, 'unit' => 'pcs', 'status' => 'active', 'sim_type' => 'area', 'sim_coverage' => 0.25, 'sim_units_per_pack' => 1, 'sim_waste_percent' => 10, 'sim_rounding' => 'ceil'],
        ];

        foreach ($products as $p) {
            Product::create([
                'brand_id' => $p['brand'] ? $brand($p['brand']) : null,
                'category_id' => $cat($p['category']),
                'sku' => $p['sku'],
                'name' => $p['name'],
                'slug' => str($p['name'])->slug().'-'.$p['sku'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'unit' => $p['unit'],
                'status' => $p['status'],
                'sim_type' => $p['sim_type'],
                'sim_coverage' => $p['sim_coverage'] ?? null,
                'sim_units_per_pack' => $p['sim_units_per_pack'] ?? 1,
                'sim_waste_percent' => $p['sim_waste_percent'] ?? null,
                'sim_rounding' => $p['sim_rounding'] ?? null,
            ]);
        }
    }
}