<?php

use App\Enums\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guests are redirected to the login page', function () {
    $response = $this->get(route('appointments.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the appointments index page', function () {
    $user = User::factory()->create()->assignRole(Role::Customer);
    $this->actingAs($user);

    $response = $this->get(route('appointments.index'));
    $response->assertOk();
});
