<?php

use App\Models\Comment;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Admin User',
    ]);
    $this->user->assignRole('administrator');
});

it('can show all comments', function () {
    Comment::factory(10)->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Comments/Index')
                ->has('comments.data', 10)
        );
});

it('can paginate comments', function () {
    Comment::factory(20)->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Comments/Index')
                ->has('comments.data', 10)
        );
});

it('can search comments', function () {
    Comment::factory()->create([
        'content' => 'First comment',
    ]);

    Comment::factory()->create([
        'content' => 'Second comment',
    ]);

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.index', ['search' => 'first']))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Comments/Index')
                ->has('comments.data', 1)
                ->where('comments.data.0.content', 'First comment')
        );
});

it('can show update comment page', function () {
    $comment = Comment::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.show', $comment))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Comments/Show')
                ->has('comment')
                ->where('comment.data.content', $comment->content)
                ->where('comment.data.author', $comment->author->name)
        );
});

it('can update comment', function () {
    $comment = Comment::factory()->create([
        'content' => 'First comment',
    ]);

    $this
        ->actingAs($this->user)
        ->put(route('admin.comments.update', $comment), [
            'content' => 'New comment',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.show', $comment))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Comments/Show')
                ->has('comment')
                ->where('comment.data.content', 'New comment')
        );
});

it('can delete comment', function () {
    $comment = Comment::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.comments.destroy', $comment));

    $this->assertDatabaseCount('comments', 0);
});
