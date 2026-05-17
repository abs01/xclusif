<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostMediaFactory extends Factory
{
    public function definition(): array
    {
        // Genera un nombre basado en tus archivos existentes (1.jpg, 2.jpg, etc.)
        $imageNumber = fake()->numberBetween(1, 4);
        
        return [
            'file_path' => $imageNumber . '.jpg',
            'post_id' => Post::inRandomOrder()->value('id') ?? Post::factory(),
            'type' => 'image',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}