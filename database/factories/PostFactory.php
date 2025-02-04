<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'body' => $this->faker->paragraph(),
            'published_at' => $this->faker->randomElement([Carbon::now()->subDays(60), Carbon::now()]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
