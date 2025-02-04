<?php

use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('can show all categories', function () {
    Category::factory(10)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Index')
            ->has('categories.data', 10)
        );
});

it('can paginate categories', function () {
    Category::factory(20)->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Index')
            ->has('categories.data', 10)
        );
});

it('can search categories', function () {
    Category::factory()->create([
        'name' => 'First Category',
    ]);

    Category::factory()->create([
        'name' => 'Second Category',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.index', ['search' => 'first']))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Index')
            ->has('categories.data', 1)
            ->where('categories.data.0.name', 'First Category')
        );
});

it('can show dash for empty description', function () {
    Category::factory()->create([
        'description' => null,
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Index')
            ->has('categories.data', 1)
            ->where('categories.data.0.description', '-')
        );
});

it('can create new category', function () {
    $this
        ->actingAs(User::factory()->create())
        ->post(route('admin.categories.store', [
            'name' => 'First Category',
        ]))
        ->assertSessionHasNoErrors();
    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Index')
            ->has('categories.data', 1)
            ->where('categories.data.0.name', 'First Category')
        );
});

it('cannot create new category with duplicate slug', function () {
    Category::factory()->create([
        'slug' => 'category-1',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->post(route('admin.categories.store', [
            'name' => 'First Category',
            'slug' => 'category-1',
        ]))
        ->assertSessionHasErrors('slug');
});

it('can show update category page', function () {
    $category = Category::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.show', $category))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Edit')
            ->has('category')
            ->where('category.name', $category->name)
            ->where('category.slug', $category->slug)
        );
});

it('can update category', function () {
    $category = Category::factory()->create([
        'name' => 'First Category',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->put(route('admin.categories.update', $category), [
            'name' => 'Second Category',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.categories.show', $category))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Categories/Edit')
            ->has('category')
            ->where('category.name', 'Second Category')
        );
});

it('cannot update category with duplicate slug', function () {
    Category::factory()->create([
        'slug' => 'category-1',
    ]);

    $category = Category::factory()->create([
        'slug' => 'category-2',
    ]);

    $this
        ->actingAs(User::factory()->create())
        ->put(route('admin.categories.update', $category), [
            'slug' => 'category-1',
        ])
        ->assertSessionHasErrors('slug');
});

it('can delete category', function () {
    $category = Category::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->delete(route('admin.categories.destroy', $category))
        ->assertSessionHasNoErrors();
});
