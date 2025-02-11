<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
