<?php

use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('customers users can\'t visit the dashboard', function () {
    $user = User::factory()->create()->assignRole(Role::Customer);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertForbidden();
});

test('barbers users can\'t visit the dashboard', function () {
    $user = User::factory()->create()->assignRole(Role::Barber);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertForbidden();
});

test('the owner users can visit the dashboard', function () {
    $user = User::factory()->create()->assignRole(Role::Owner);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});
