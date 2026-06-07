<?php

namespace Database\Seeders;

use App\Models\Sponsors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $jsonData = file_get_contents("database\jsons\sponsors.json");
        $sponsors = json_decode($jsonData, true);

        foreach ($sponsors['sponsors']['sponsor'] as $sponsor) {
            Sponsors::create([
                'company_name' => $sponsor['company_name'],
                'content' => $sponsor['content'],
                'file_path' => $sponsor['file_path'],
                'publicity_url' => $sponsor['publicity_url'],
                'is_active' => true, // Puedes ajustar esto según tus necesidades en el backoffice
            ]);
        }
    }
}
        

