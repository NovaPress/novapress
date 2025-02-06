<?php

use App\Models\Comment;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('cannot show index page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot show specific comment page without permission', function () {
    $comment = Comment::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.comments.show', $comment))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot edit comment without permission', function () {
    $comment = Comment::factory()->create();

    $this
        ->actingAs($this->user)
        ->put(route('admin.comments.update', $comment), [
            'content' => 'New content',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot delete comment without permission', function () {
    $comment = Comment::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.comments.destroy', $comment))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});
