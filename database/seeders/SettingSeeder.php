<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'Juragan Material',
            'wa_number' => '6281234567890',
            'admin_email' => 'admin@juraganmaterial.test',
            'address' => 'Jl. Contoh No. 1, Jakarta',
            'logo_url' => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}