<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('cannot show index page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot show create page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot show specific user page without permission', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.show', $user))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot show user profile page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.profile'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot create user without permission', function () {
    $this
        ->actingAs($this->user)
        ->post(route('admin.users.store', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role' => 'subscriber',
        ]))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot edit user without permission', function () {
    $user = User::factory()->create();
    $user->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->put(route('admin.users.update', $user), [
            'name' => 'John Doe',
        ])
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});

it('cannot delete user without permission', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.users.destroy', $user))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Error/403')
        );
});
