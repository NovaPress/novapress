<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('cannot show general settings page without permission', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.settings.general'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});

it('cannot edit general settings without permission', function () {
    $request = [
        'site_title' => 'value',
        'site_icon' => 'value',
        'site_url' => 'value',
        'admin_email' => 'value',
        'registration' => 'value',
        'default_role' => 'value',
        'language' => 'value',
        'timezone' => 'value',
        'date_format' => 'value',
        'time_format' => 'value',
    ];
    $this
        ->actingAs($this->user)
        ->put(route('admin.settings.general.update'), $request)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Error/403')
        );
});
