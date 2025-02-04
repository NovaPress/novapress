<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Inertia\Testing\AssertableInertia as Assert;

it('can show login page', function () {
    $this
        ->get(route('admin.login'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Auth/Login')
        );
});

it('cannot show login page if logged in', function () {
    $this
        ->actingAs(User::factory()->create())
        ->get(route('admin.login'))
        ->assertRedirect(route('admin.index'));
});

it('can log in user', function () {
    $user = User::factory()->create();

    $response = $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect(route('admin.index'));
});

it('cannot log in user with wrong password', function () {
    $user = User::factory()->create();

    $response = $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

it('can show forgot password page', function () {
    $this->get(route('admin.password.request'))
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Auth/ForgotPassword')
        );
});

it('can send reset password email', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('admin.password.email', ['email' => $user->email]));

    Notification::assertSentTo($user, ResetPassword::class);
});

it('can show reset password form', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('admin.password.email', ['email' => $user->email]));

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get(route('admin.password.reset', ['token' => $notification->token]));

        $response->assertStatus(200);
        $response->assertInertia(fn(Assert $page) => $page
            ->component('Admin/Auth/ResetPassword')
        );

        return true;
    });
});

it('can reset password with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('admin.password.email', ['email' => $user->email]));

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(route('admin.password.update', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.login'));

        return true;
    });
});

it('cannot reset password with invalid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('admin.password.email', ['email' => $user->email]));

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(route('admin.password.update', [
            'token' => 'wrong-token',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));

        $response
            ->assertSessionHasErrors()
            ->assertRedirect('/');

        return true;
    });
});

it('can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('admin.logout'));

    $this->assertGuest();
    $response->assertRedirect('/');
});

it('can rate limit on multiple login attempts', function () {
    $user = User::factory()->create();

    $i = 1;
    while ($i <= 61) {
        $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $i++;
    };

    $response = $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(302);
    $response->assertSessionHasErrors();
});
