<?php

use App\Models\Tag;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->givePermissionTo(['view_tags', 'create_tags', 'edit_tags', 'delete_tags']);
});

it('can show all tags', function () {
    Tag::factory(10)->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Tags/Index')
                ->has('tags.data', 10)
        );
});

it('can paginate tags', function () {
    Tag::factory(20)->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
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
        ->actingAs($this->user)
        ->get(route('admin.tags.index', ['search' => 'first']))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
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
        ->actingAs($this->user)
        ->get(route('admin.tags.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Tags/Index')
                ->has('tags.data', 1)
                ->where('tags.data.0.description', '-')
        );
});

it('can create new tag', function () {
    $this
        ->actingAs($this->user)
        ->post(route('admin.tags.store', [
            'name' => 'First Tag',
        ]))
        ->assertSessionHasNoErrors();
    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.index'))
        ->assertInertia(
            fn (Assert $page) => $page
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
        ->actingAs($this->user)
        ->post(route('admin.tags.store', [
            'name' => 'First Tag',
            'slug' => 'tag-1',
        ]))
        ->assertSessionHasErrors('slug');
});

it('can show update tag page', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.show', $tag))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Tags/Show')
                ->has('tag')
                ->where('tag.data.name', $tag->name)
                ->where('tag.data.slug', $tag->slug)
        );
});

it('can update tag', function () {
    $tag = Tag::factory()->create([
        'name' => 'First Tag',
    ]);

    $this
        ->actingAs($this->user)
        ->put(route('admin.tags.update', $tag), [
            'name' => 'Second Tag',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs($this->user)
        ->get(route('admin.tags.show', $tag))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Tags/Show')
                ->has('tag')
                ->where('tag.data.name', 'Second Tag')
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
        ->actingAs($this->user)
        ->put(route('admin.tags.update', $tag), [
            'slug' => 'tag-1',
        ])
        ->assertSessionHasErrors('slug');
});

it('can delete tag', function () {
    $tag = Tag::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.tags.destroy', $tag))
        ->assertSessionHasNoErrors();
});
