<?php

use App\Models\Tag;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('cannot show index page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot show specific tag page without permission', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.show', $tag))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot create tag without permission', function () {
    $this
        ->actingAs($this->user)
        ->post(route('admin.tags.store', [
            'name' => 'Tag 1',
        ]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot edit tag without permission', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs($this->user)
        ->put(route('admin.tags.update', $tag), [
            'name' => 'New Tag',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot delete tag without permission', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.tags.destroy', $tag))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});
