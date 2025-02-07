<?php

use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('cannot show index page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.categories.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot show specific category page without permission', function () {
    $category = Category::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.categories.show', $category))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot create category without permission', function () {
    $this
        ->actingAs($this->user)
        ->post(route('admin.categories.store', [
            'name' => 'Category 1',
        ]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot edit category without permission', function () {
    $category = Category::factory()->create();

    $this
        ->actingAs($this->user)
        ->put(route('admin.categories.update', $category), [
            'name' => 'New Category',
        ])
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot delete category without permission', function () {
    $category = Category::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.categories.destroy', $category))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});
