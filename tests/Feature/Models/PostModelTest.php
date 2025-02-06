<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->post = Post::factory()->create([
        'title' => 'First Post',
    ]);
});

it('can create a post', function () {
    $this->assertDatabaseHas('posts', [
        'title' => $this->post->title,
    ]);

    $this->assertDatabaseCount('posts', 1);
});

it('can update a post', function () {
    $this->post->title = 'Updated Post';
    $this->post->save();

    $this->assertDatabaseHas('posts', [
        'title' => 'Updated Post',
    ]);

    $this->assertDatabaseMissing('posts', [
        'title' => 'First Post',
    ]);

    $this->assertDatabaseCount('posts', 1);
});

it('can delete a post', function () {
    $this->post->delete();

    $this->assertDatabaseMissing('posts', [
        'title' => $this->post->title,
    ]);

    $this->assertDatabaseCount('posts', 0);
});

it('can get post author', function () {
    $this->assertDatabaseHas('posts', [
        'user_id' => $this->post->user_id,
    ]);

    $post = Post::first();

    $this->assertEquals($this->post->user_id, $post->author->id);
});

it('can assign post author', function () {
    $user = User::factory()->create();

    Post::factory()->create([
        'user_id' => $user->id,
        'title' => 'New Post',
    ]);

    $post = Post::find(2);

    $this->assertEquals($user->id, $post->author->id);
});

it('can update post author', function () {
    $user = User::factory()->create();
    $post = Post::first();

    $post->author()->associate($user);

    $this->assertEquals($user->id, $post->author->id);
});

it('can get post categories', function () {
    $category = Category::factory()->create();

    $this->post->categories()->attach($category);

    $this->assertEquals(1, $this->post->categories()->count());

    $this->assertEquals($category->name, $this->post->categories()->first()->name);
});

it('can attach post categories', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $this->post->categories()->attach($category1);
    $this->post->categories()->attach($category2);

    $this->assertEquals(2, $this->post->categories()->count());
    $this->assertEquals($category2->name, $this->post->categories()->find(2)->name);
});

it('can detach post categories', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $this->post->categories()->attach($category1);
    $this->post->categories()->attach($category2);

    $this->assertEquals(2, $this->post->categories()->count());

    $this->post->categories()->detach($category1);

    $this->assertEquals(1, $this->post->categories()->count());

    $this->assertEquals($category2->name, $this->post->categories()->first()->name);
});

it('can get post tags', function () {
    $tag = Tag::factory()->create();

    $this->post->tags()->attach($tag);

    $this->assertEquals(1, $this->post->tags()->count());

    $this->assertEquals($tag->name, $this->post->tags()->first()->name);
});

it('can attach post tags', function () {
    $tag1 = Tag::factory()->create();
    $tag2 = Tag::factory()->create();

    $this->post->tags()->attach($tag1);
    $this->post->tags()->attach($tag2);

    $this->assertEquals(2, $this->post->tags()->count());
    $this->assertEquals($tag2->name, $this->post->tags()->find(2)->name);
});

it('can detach post tags', function () {
    $tag1 = Tag::factory()->create();
    $tag2 = Tag::factory()->create();

    $this->post->tags()->attach($tag1);
    $this->post->tags()->attach($tag2);

    $this->assertEquals(2, $this->post->tags()->count());

    $this->post->tags()->detach($tag1);

    $this->assertEquals(1, $this->post->tags()->count());

    $this->assertEquals($tag2->name, $this->post->tags()->first()->name);
});

it('can get posts comments', function () {
    $comment = Comment::factory()->create([
        'post_id' => $this->post->id,
    ]);

    $this->assertEquals(1, $this->post->comments()->count());

    $this->assertEquals($comment->content, $this->post->comments()->first()->content);
});
