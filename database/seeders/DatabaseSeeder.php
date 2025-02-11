<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            UsersSeeder::class,
            SettingsSeeder::class,
            CategoriesSeeder::class,
            TagsSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class,
        ]);
    }
}
