<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Admin User',
    ]);
    $this->user->assignRole('administrator');
});

it('can show all users', function () {
    $users = User::factory(9)->create();
    foreach ($users as $user) {
        $user->assignRole('subscriber');
    }

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Index')
            ->has('users.data', 10)
        );
});

it('can paginate users', function () {
    $users = User::factory(20)->create();
    foreach ($users as $user) {
        $user->assignRole('subscriber');
    }

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Index')
            ->has('users.data', 10)
        );
});

it('can search users', function () {
    $user1 = User::factory()->create([
        'name' => 'John Doe',
    ]);

    $user2 = User::factory()->create([
        'name' => 'Jane Doe',
    ]);
    $user1->assignRole('subscriber');
    $user2->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.index', ['search' => 'john']))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Index')
            ->has('users.data', 1)
            ->where('users.data.0.name', 'John Doe')
        );
});

it('can create new user', function () {
    $this
        ->actingAs($this->user)
        ->post(route('admin.users.store', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'role' => 'subscriber',
        ]))
        ->assertSessionHasNoErrors();
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Index')
            ->has('users.data', 2)
            ->where('users.data.1.name', 'John Doe')
        );
});

it('cannot create new user with duplicate email', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
    ]);
    $user->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->post(route('admin.users.store', [
            'name' => 'John Doe',
            'email' => 'user@example.com',
        ]))
        ->assertSessionHasErrors('email');
});

it('can show create user page', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Show')
        );
});

it('can show update user page', function () {
    $user = User::factory()->create();
    $user->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.show', $user))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Show')
            ->has('user')
            ->where('user.data.name', $user->name)
            ->where('user.data.email', $user->email)
        );
});

it('can update user', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);
    $user->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->put(route('admin.users.update', $user), [
            'name' => 'Jane Doe',
            'role' => 'subscriber',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.show', $user))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Show')
            ->has('user')
            ->where('user.data.name', 'Jane Doe')
        );
});

it('cannot update user with duplicate email', function () {
    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $user = User::factory()->create([
        'email' => 'jane@example.com',
    ]);

    $this
        ->actingAs($this->user)
        ->put(route('admin.users.update', $user), [
            'email' => 'john@example.com',
        ])
        ->assertSessionHasErrors('email');
});

it('can delete user', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($this->user)
        ->delete(route('admin.users.destroy', $user));

    $this->assertDatabaseCount('users', 1);
});

it('can show profile page', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.users.profile'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Show')
        );
});

it('can update user role', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);
    $user->assignRole('subscriber');

    $this
        ->actingAs($this->user)
        ->put(route('admin.users.update', $user), [
            'name' => 'Jane Doe',
            'role' => 'editor',
        ])
        ->assertSessionHasNoErrors();

    $this
        ->actingAs($this->user)
        ->get(route('admin.users.show', $user))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Users/Show')
            ->has('user')
            ->where('user.data.name', 'Jane Doe')
            ->where('user.data.role', 'editor')
        );
});
