<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $post = Post::find(Post::pluck('id')->random());
        
        // Obtener o crear un usuario que no sea el del post
        $user = User::whereNotIn('id', [$post->user_id])->first();
        if (!$user) {
            $user = User::factory()->create();
        }
        
        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => fake()->sentence()
        ];
    }
}