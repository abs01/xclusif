<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Model>
 */
class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
             return [
            'follower_id' => User::factory(),
            'following_id' => User::factory(),
            'is_vip' => fake()->boolean(20)

            ];
    }
}
