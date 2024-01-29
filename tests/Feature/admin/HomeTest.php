<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses()->group('admin', 'admin.home');

it('requires authentication', function () {
    get(route('admin.home'))
        ->assertRedirectToRoute('login');
});

it('requires admin.home permission', function () {
    actingAs(User::factory()->create())
        ->get(route('admin.home'))
        ->assertForbidden();
});

it('successfully renders admin.home', function () {
    actingAs(
        User::factory()
            ->create()
            ->givePermissionTo('admin.home')
    )
        ->get(route('admin.home'))
        ->assertSuccessful()
        ->assertViewIs('admin.home')
        ->assertSeeTitle([])
        ->assertSeeForm(['logout'])
        ->assertSeeInput('_token')
        ->assertSeeLink(['admin.home']);
});
