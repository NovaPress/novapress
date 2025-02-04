<?php

use App\Models\Tag;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('can show all tags', function () {
    Tag::factory(10)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Index')
            ->has('tags.data', 10)
        );
});

it('can paginate tags', function () {
    Tag::factory(20)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Index')
            ->has('tags.data', 10)
        );
});

it('can search tags', function () {
    Tag::factory()->create([
        'name' => 'First Tag',
    ]);

    Tag::factory()->create([
        'name' => 'Second Tag',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.index', ['search' => 'first']))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Index')
            ->has('tags.data', 1)
            ->where('tags.data.0.name', 'First Tag')
        );
});

it('can show dash for empty description', function () {
    Tag::factory()->create([
        'description' => null,
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Index')
            ->has('tags.data', 1)
            ->where('tags.data.0.description', '-')
        );
});

it('can create new tag', function () {
    $this
        ->actingAs(User::factory()->create())
        ->post(route('admin.tags.store', [
            'name' => 'First Tag',
        ]))
        ->assertSessionHasNoErrors();
    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.index'))
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Index')
            ->has('tags.data', 1)
            ->where('tags.data.0.name', 'First Tag')
        );
});

it('cannot create new tag with duplicate slug', function () {
    Tag::factory()->create([
        'slug' => 'tag-1',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->post(route('admin.tags.store', [
            'name' => 'First Tag',
            'slug' => 'tag-1',
        ]))
        ->assertSessionHasErrors('slug');
});

it('can show update tag page', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.show', $tag))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Edit')
            ->has('tag')
            ->where('tag.name', $tag->name)
            ->where('tag.slug', $tag->slug)
        );
});

it('can update tag', function () {
    $tag = Tag::factory()->create([
        'name' => 'First Tag',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->put(route('admin.tags.update', $tag), [
            'name' => 'Second Tag',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.tags.show', $tag))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Tags/Edit')
            ->has('tag')
            ->where('tag.name', 'Second Tag')
        );
});

it('cannot update tag with duplicate slug', function () {
    Tag::factory()->create([
        'slug' => 'tag-1',
    ]);

    $tag = Tag::factory()->create([
        'slug' => 'tag-2',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->put(route('admin.tags.update', $tag), [
            'slug' => 'tag-1',
        ])
        ->assertSessionHasErrors('slug');
});

it('can delete tag', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->delete(route('admin.tags.destroy', $tag))
        ->assertSessionHasNoErrors();
});
