<?php

use App\Models\Tag;
use App\Models\Post;

beforeEach(function () {
    $this->tag = Tag::factory()->create([
        'name' => 'First Tag',
    ]);
});

it('can create a tag', function () {
    $this->assertDatabaseHas('tags', [
        'name' => $this->tag->name,
    ]);

    $this->assertDatabaseCount('tags', 1);
});

it('can update a tag', function () {
    $this->tag->name = 'Updated Tag';
    $this->tag->save();

    $this->assertDatabaseHas('tags', [
        'name' => 'Updated Tag',
    ]);

    $this->assertDatabaseMissing('tags', [
        'name' => 'First Tag',
    ]);

    $this->assertDatabaseCount('tags', 1);
});

it('can delete a tag', function () {
    $this->tag->delete();

    $this->assertDatabaseMissing('tags', [
        'name' => $this->tag->name,
    ]);

    $this->assertDatabaseCount('tags', 0);
});

it('can get tag posts', function () {
    $post = Post::factory()->create();
    $post->tags()->attach($this->tag->id);


    $this->assertEquals(1, $this->tag->posts()->count());

    $this->assertEquals($post->title, $this->tag->posts()->first()->title);
});

it('can attach posts to tag', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $this->tag->posts()->attach($post1);
    $this->tag->posts()->attach($post2);

    $this->assertEquals(2, $this->tag->posts()->count());
    $this->assertEquals($post2->title, $this->tag->posts()->find(2)->title);
});

it('can detach posts from tag', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $this->tag->posts()->attach($post1);
    $this->tag->posts()->attach($post2);

    $this->assertEquals(2, $this->tag->posts()->count());

    $this->tag->posts()->detach($post1);

    $this->assertEquals(1, $this->tag->posts()->count());

    $this->assertEquals($post2->title, $this->tag->posts()->first()->title);
});
