<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Vasileios Ntoufoudis',
            'email' => 'info@ntoufoudis.com',
        ]);

        $users = User::factory(20)->create();

        Post::factory(100)
            ->recycle($users)
            ->create();
    }
}
