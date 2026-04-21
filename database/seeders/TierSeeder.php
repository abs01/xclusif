<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tier;

class TierSeeder extends Seeder
{
    public function run(): void
    {
        Tier::create([
            'name' => 'free',
            'monetization' => false
        ]);

        Tier::create([
            'name' => 'gold',
            'monetization' => true,
            'comments_required' => 50
        ]);

        Tier::create([
            'name' => 'diamond',
            'monetization' => true,
            'comments_required' => 25
        ]);
    }
}