<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'Apakah bisa pesan dalam jumlah besar?', 'answer' => 'Ya, gunakan fitur RFQ untuk penawaran khusus proyek.', 'sort_order' => 1],
            ['question' => 'Bagaimana cara pembayaran?', 'answer' => 'Pembayaran dikonfirmasi via WhatsApp setelah pesanan dibuat.', 'sort_order' => 2],
            ['question' => 'Apakah ada pengiriman?', 'answer' => 'Tersedia pickup dan kurir; biaya ongkir disesuaikan admin.', 'sort_order' => 3],
        ];

        foreach ($faqs as $f) {
            Faq::create($f);
        }
    }
}