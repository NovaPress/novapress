<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('can show admin dashboard page', function () {
    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Dashboard')
        );
});

it('cannot show admin dashboard page if not logged in', function () {
    $this
        ->get(route('admin.index'))
        ->assertRedirect(route('admin.login'));
});
