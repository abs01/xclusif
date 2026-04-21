<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TierSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $users = User::factory(100)->create();
            $usersIds = User::pluck('id');

        foreach ($users as $user) {

            $posts = Post::factory(rand(1,5))->create([
                'user_id' => $user->id
            ]);

            foreach ($posts as $post) {

                Comment::factory(rand(1,3))->create([
                    'post_id' => $post->id,
                    'user_id' => $user->id
                ]);
            }

            foreach ($posts as $post) {
                $likesCount = rand(1,2);
                for ($i = 0; $i < $likesCount; $i++) {
                    Like::firstOrCreate([
                        'post_id' => $post->id,
                        'user_id' => $usersIds->random(),
                    ]);
                }
            }
        }


        // GENERAR FOLLOWERS
        foreach ($users as $user) {

            $randomUsers = $users->random(rand(5,20));

            foreach ($randomUsers as $follower) {

                if ($follower->id !== $user->id) {

                    $user->followers()->attach($follower->id, [
                        'is_vip' => fake()->boolean(20)
                    ]);

                }

            }

        }

    }
}