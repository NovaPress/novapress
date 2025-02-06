<?php

use App\Models\Category;
use App\Models\Post;

beforeEach(function () {
    $this->category = Category::factory()->create([
        'name' => 'First Category',
    ]);
});

it('can create a category', function () {
    $this->assertDatabaseHas('categories', [
        'name' => $this->category->name,
    ]);

    $this->assertDatabaseCount('categories', 1);
});

it('can update a category', function () {
    $this->category->name = 'Updated Category';
    $this->category->save();

    $this->assertDatabaseHas('categories', [
        'name' => 'Updated Category',
    ]);

    $this->assertDatabaseMissing('categories', [
        'name' => 'First Category',
    ]);

    $this->assertDatabaseCount('categories', 1);
});

it('can delete a category', function () {
    $this->category->delete();

    $this->assertDatabaseMissing('categories', [
        'name' => $this->category->name,
    ]);

    $this->assertDatabaseCount('categories', 0);
});

it('can get category posts', function () {
    $post = Post::factory()->create();
    $post->categories()->attach($this->category->id);

    $this->assertEquals(1, $this->category->posts()->count());

    $this->assertEquals($post->title, $this->category->posts()->first()->title);
});

it('can attach posts to category', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $this->category->posts()->attach($post1);
    $this->category->posts()->attach($post2);

    $this->assertEquals(2, $this->category->posts()->count());
    $this->assertEquals($post2->title, $this->category->posts()->find(2)->title);
});

it('can detach posts from category', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    $this->category->posts()->attach($post1);
    $this->category->posts()->attach($post2);

    $this->assertEquals(2, $this->category->posts()->count());

    $this->category->posts()->detach($post1);

    $this->assertEquals(1, $this->category->posts()->count());

    $this->assertEquals($post2->title, $this->category->posts()->first()->title);
});
