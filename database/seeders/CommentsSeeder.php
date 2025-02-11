<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        Comment::factory(500)
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'user_id' => random_int(6, 20),
                    'post_id' => random_int(1, 100),
                ]
            ))
            ->create();
    }
}
