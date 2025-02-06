<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('can show all posts', function () {
    Post::factory(10)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.posts.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Posts/Index')
                ->has('posts.data', 10)
        );
});

it('can paginate posts', function () {
    Post::factory(20)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.posts.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Posts/Index')
                ->has('posts.data', 10)
        );
});

it('can search posts', function () {
    Post::factory()->create([
        'title' => 'First Post',
    ]);

    Post::factory()->create([
        'title' => 'Second Post',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.posts.index', ['search' => 'first']))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Posts/Index')
                ->has('posts.data', 1)
                ->where('posts.data.0.title', 'First Post')
        );
});

it('can show Not Published for posts that are not published', function () {
    Post::factory()->create([
        'published_at' => null,
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.posts.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Posts/Index')
                ->has('posts.data', 1)
                ->where('posts.data.0.published_at', 'Not Published')
        );
});
