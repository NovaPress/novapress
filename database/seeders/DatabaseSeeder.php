<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
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
        ]);

        $administrator = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@example.com',
        ]);

        $editor = User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
        ]);

        $author = User::factory()->create([
            'name' => 'Author',
            'email' => 'author@example.com',
        ]);

        $contributor = User::factory()->create([
            'name' => 'Contributor',
            'email' => 'contributor@example.com',
        ]);

        $subscriber = User::factory()->create([
            'name' => 'Subscriber',
            'email' => 'subscriber@example.com',
        ]);

        $administrator->assignRole('administrator');
        $editor->assignRole('editor');
        $author->assignRole('author');
        $contributor->assignRole('contributor');
        $subscriber->assignRole('subscriber');

        $users = User::factory(20)->create();
        foreach ($users as $user) {
            $user->assignRole('subscriber');
        }

        $categories = Category::factory(10)->create();

        $tags = Tag::factory(10)->create();

        $posts = Post::factory(100)
            ->recycle($users)
            ->create();

        foreach ($posts as $post) {
            $post->categories()->attach(random_int(1, count($categories)));
            $post->tags()->attach(random_int(1, count($tags)));
        }
    }
}
