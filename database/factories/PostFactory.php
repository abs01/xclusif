<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'content' => fake()->paragraph()
        ];
    }
}