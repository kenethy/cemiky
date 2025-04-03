<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Netflix',
                'website' => 'https://www.netflix.com/',
                // Jika Netflix tidak menggunakan harga bulanan/tahunan, biarkan null atau isi dengan keterangan
                'monthly_price' => '9.99$',
                'yearly_price'  => '99$',
                'logo' => 'streaming/netflix.png'
            ],
            [
                'name' => 'WeTV',
                'website' => 'https://wetv.example.com/',
                'monthly_price' => '6.99$',
                'yearly_price'  => '89.99$',
                'logo' => 'streaming/wetv.png'
            ],
            [
                'name' => 'Disney+ Hotstar',
                'website' => 'https://www.hotstar.com/',
                'monthly_price' => '9.99$',
                'yearly_price'  => '89.99$',
                'logo' => 'streaming/disneyplus.png'
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create([
                'id'            => Str::uuid(),
                'name'          => $plan['name'],
                'website'       => $plan['website'],
                'monthly_price' => $plan['monthly_price'],
                'yearly_price'  => $plan['yearly_price'],
                'logo'          => $plan['logo'],
            ]);
        }
    }
}
