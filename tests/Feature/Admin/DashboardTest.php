<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('can show admin dashboard page', function () {
    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.index'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Dashboard')
        );
});

it('cannot show admin dashboard page if not logged in', function () {
    $this
        ->get(route('admin.index'))
        ->assertRedirect(route('admin.login'));
});

it('can create draft in dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.store-draft', [
            'title' => 'Draft Title',
            'content' => 'Draft Content',
        ]))
        ->assertRedirect(route('admin.index'));

    $this->assertDatabaseHas('posts', [
        'title' => 'Draft Title',
        'body' => 'Draft Content',
    ]);

    $this->assertDatabaseCount('posts', 1);
});
