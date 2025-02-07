<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\LoginPage;

uses(DatabaseTruncation::class);

it('can login user', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit(new LoginPage)
            ->type('@email', $user->email)
            ->type('@password', 'password')
            ->press('@submit')
            ->pause(1000)
            ->assertPathIs('/admin');
    });
});
