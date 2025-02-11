<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\SettingsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->givePermissionTo(['view_settings', 'edit_settings']);

    app(DatabaseSeeder::class)->call(SettingsSeeder::class);
});

it('can show general settings', function () {
    $this
        ->actingAs($this->user)
        ->get(route('admin.settings.general'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Settings/General')
                ->has('settings', 10)
        );
});

it('can update general settings', function () {
    $request = [
        'site_title' => 'New Site',
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
        ->put(route('admin.settings.general.update', $request))
        ->assertSessionHasNoErrors();

    $this
        ->actingAs($this->user)
        ->get(route('admin.settings.general'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Admin/Settings/General')
                ->has('settings', 10)
                ->where('settings.0.value', 'New Site')
        );
});
