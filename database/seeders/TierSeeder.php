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
            'interactions_required' => 50
        ]);

        Tier::create([
            'name' => 'diamond',
            'monetization' => true,
            'interactions_required' => 25
        ]);
    }
}