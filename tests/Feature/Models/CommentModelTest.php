<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->comment = Comment::factory()->create([
        'content' => 'test comment',
    ]);
});

it('can create a comment', function () {
    $this->assertDatabaseHas('comments', [
        'content' => $this->comment->content,
    ]);

    $this->assertDatabaseCount('comments', 1);
});

it('can update a comment', function () {
    $this->comment->content = 'New content';
    $this->comment->save();

    $this->assertDatabaseHas('comments', [
        'content' => 'New content',
    ]);

    $this->assertDatabaseMissing('comments', [
        'content' => 'test comment',
    ]);

    $this->assertDatabaseCount('comments', 1);
});

it('can delete a comment', function () {
    $this->comment->delete();

    $this->assertDatabaseMissing('comments', [
        'name' => $this->comment->content,
    ]);

    $this->assertDatabaseCount('comments', 0);
});

it('can get comments post', function () {
    $post = Post::factory()->create();

    $comment = Comment::factory()->create([
        'post_id' => $post->id,
    ]);

    $this->assertEquals($post->title, $comment->post->title);
});

it('can get comments author', function () {
    $user = User::factory()->create();

    $comment = Comment::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->assertEquals($user->name, $comment->author->name);
});
