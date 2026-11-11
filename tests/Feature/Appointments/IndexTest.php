<?php

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->barber = User::factory()->create()->assignRole(Role::Barber);
    $this->customer = User::factory()->create()->assignRole(Role::Customer);

    $this->service = Service::factory()->create();
    $this->barber->barberServices()->attach($this->service);

    $this->appointment = Appointment::factory()->create([
        'barber_id' => $this->barber->id,
        'customer_id' => $this->customer->id,
    ]);
});

test('guests are redirected to the login page', function () {
    $response = $this->get(route('appointments.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the appointments index page', function () {
    Livewire::actingAs($this->customer)
        ->test('pages::appointments.index')
        ->assertStatus(200);

    Livewire::actingAs($this->barber)
        ->test('pages::appointments.index')
        ->assertStatus(200);
});

test('customers can see their appointments', function () {
    $this->actingAs($this->customer);

    Livewire::test('pages::appointments.index')
        ->assertSee($this->barber->name);
});

test('customers can only see their own appointments', function () {
    // Other customer with 5 appointments
    $stranger = User::factory()
        ->has(Appointment::factory()->count(5))
        ->create()
        ->assignRole(Role::Customer);

    $component = Livewire::actingAs($this->customer)->test('pages::appointments.index');
    $strangerComponent = Livewire::actingAs($stranger)->test('pages::appointments.index');

    expect($component->instance()->appointments)->toHaveCount(1);
    expect($strangerComponent->instance()->appointments)->toHaveCount(5);
});

test('customers can\'t see the modify and cancel button of a cancelled appointment', function () {
    $this->appointment->update([
        'status' => AppointmentStatus::Cancelled,
    ]);

    Livewire::actingAs($this->customer)
        ->test('pages::appointments.index')
        ->assertSee($this->appointment->date)
        ->assertDontSee(__('Modify appointment'))
        ->assertDontSee(__('Cancel appointment'));
});

test('barbers can only see their own appointments', function () {
    // Other barber with 5 appointments
    $stranger = User::factory()
        ->create()
        ->assignRole(Role::Barber);

    Appointment::factory()
        ->count(5)
        ->for($stranger, 'barber')
        ->create();

    $component = Livewire::actingAs($this->barber)->test('pages::appointments.index');
    $strangerComponent = Livewire::actingAs($stranger)->test('pages::appointments.index');

    expect($component->instance()->appointments)->toHaveCount(1);
    expect($strangerComponent->instance()->appointments)->toHaveCount(5);
});

test('barbers can\'t see the modify and cancel button of a cancelled appointment', function () {
    $this->appointment->update([
        'status' => AppointmentStatus::Cancelled,
    ]);

    Livewire::actingAs($this->barber)
        ->test('pages::appointments.index')
        ->assertSee($this->appointment->date)
        ->assertDontSee(__('Modify appointment'))
        ->assertDontSee(__('Cancel appointment'));
});
