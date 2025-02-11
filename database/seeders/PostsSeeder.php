<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::factory(100)
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'user_id' => random_int(6, 20),
                ]
            ))
            ->create();

        foreach ($posts as $post) {
            $numbers = range(1, 10);
            $cTimes = rand(1, 5);
            $tTimes = rand(1, 5);
            shuffle($numbers);
            $categories = array_slice($numbers, 0, $cTimes);
            $tags = array_slice($numbers, 0, $tTimes);
            $post->categories()->sync($categories);
            $post->tags()->sync($tags);
        }
    }
}
