<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'John Doe',
    ]);
});

it('can create a user', function () {
    $this->assertDatabaseHas('users', [
        'name' => $this->user->name,
    ]);

    $this->assertDatabaseCount('users', 1);
});

it('can update a user', function () {
    $this->user->name = 'Jane Doe';
    $this->user->save();

    $this->assertDatabaseHas('users', [
        'name' => 'Jane Doe',
    ]);

    $this->assertDatabaseMissing('users', [
        'name' => 'John Doe',
    ]);

    $this->assertDatabaseCount('users', 1);
});

it('can delete a user', function () {
    $this->user->delete();

    $this->assertDatabaseMissing('users', [
        'name' => $this->user->name,
    ]);

    $this->assertDatabaseCount('users', 0);
});

it('can get users posts', function () {
    $post = Post::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->assertEquals(1, $this->user->posts()->count());

    $this->assertEquals($post->title, $this->user->posts()->first()->title);
});
