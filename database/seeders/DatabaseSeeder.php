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
        // 1. Akun Admin Utama
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Bayu',
                'password' => bcrypt('password123'),
            ]
        );

        // 2. Data Dummy Analisis (6 Data: 2 per Platform)
        $scenarios = [
            // FACEBOOK
            [
                'campaign_name' => 'FB - Ramadhan Sale 2026',
                'platform' => 'Facebook',
                'start_date' => '2026-04-01',
                'end_date' => '2026-04-15',
                'impressions' => 50000,
                'clicks' => 2500,
                'conversions' => 120,
                'total_spend' => 500.00,
                'total_revenue' => 2500.00,
                'ai_analysis' => '### Performance Summary\nKampanye ini sangat sukses dengan ROAS 5.0x. CTR 5% menunjukkan materi kreatif sangat relevan.\n\n### Optimization\nNaikkan budget 20% setiap 3 hari.'
            ],
            [
                'campaign_name' => 'FB - Retargeting App',
                'platform' => 'Facebook',
                'start_date' => '2026-04-10',
                'end_date' => '2026-04-20',
                'impressions' => 10000,
                'clicks' => 300,
                'conversions' => 5,
                'total_spend' => 200.00,
                'total_revenue' => 150.00,
                'ai_analysis' => '### Performance Summary\nKampanye gagal (ROAS < 1). Biaya akuisisi terlalu mahal.\n\n### Optimization\nSegera ganti materi kreatif atau persempit audiens.'
            ],
            // GOOGLE
            [
                'campaign_name' => 'GG - Search Electronics',
                'platform' => 'Google',
                'start_date' => '2026-04-05',
                'end_date' => '2026-04-25',
                'impressions' => 30000,
                'clicks' => 4500,
                'conversions' => 200,
                'total_spend' => 1000.00,
                'total_revenue' => 6000.00,
                'ai_analysis' => '### Performance Summary\nDominasi di Search Ads. ROAS 6.0x sangat sehat.\n\n### Optimization\nTambahkan kata kunci negatif untuk efisiensi budget.'
            ],
            [
                'campaign_name' => 'GG - Brand Awareness',
                'platform' => 'Google',
                'start_date' => '2026-04-01',
                'end_date' => '2026-04-29',
                'impressions' => 100000,
                'clicks' => 500,
                'conversions' => 2,
                'total_spend' => 300.00,
                'total_revenue' => 50.00,
                'ai_analysis' => '### Performance Summary\nCTR sangat rendah (0.5%). Pesan iklan kurang menarik.\n\n### Optimization\nUbah copywriting Headline agar lebih provokatif.'
            ],
            // TIKTOK
            [
                'campaign_name' => 'TT - Viral Dance Challenge',
                'platform' => 'TikTok',
                'start_date' => '2026-04-15',
                'end_date' => '2026-04-25',
                'impressions' => 200000,
                'clicks' => 8000,
                'conversions' => 450,
                'total_spend' => 1500.00,
                'total_revenue' => 7500.00,
                'ai_analysis' => '### Performance Summary\nViralitas tinggi! Volume konversi luar biasa.\n\n### Optimization\nManfaatkan konten UGC dari user untuk iklan retargeting.'
            ],
            [
                'campaign_name' => 'TT - Product Unboxing',
                'platform' => 'TikTok',
                'start_date' => '2026-04-20',
                'end_date' => '2026-04-29',
                'impressions' => 40000,
                'clicks' => 1200,
                'conversions' => 30,
                'total_spend' => 400.00,
                'total_revenue' => 600.00,
                'ai_analysis' => '### Performance Summary\nPerforma rata-rata (ROAS 1.5x).\n\n### Optimization\nPerbaiki 3 detik pertama video agar hook lebih kuat.'
            ],
        ];

        foreach ($scenarios as $data) {
            $ctr = ($data['clicks'] / $data['impressions']) * 100;
            $cpc = $data['total_spend'] / $data['clicks'];
            $cpa = $data['conversions'] > 0 ? $data['total_spend'] / $data['conversions'] : 0;
            $roas = $data['total_revenue'] / $data['total_spend'];

            Analysis::create(array_merge($data, [
                'user_id' => $admin->id,
                'ctr' => $ctr,
                'cpc' => $cpc,
                'cpa' => $cpa,
                'roas' => $roas,
            ]));
        }
    }
}
