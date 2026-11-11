<?php

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

pest()->use(RefreshDatabase::class);

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

test('customers can cancel their appointments', function () {
    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee(__('Cancel appointment'))
        ->call('cancel')
        ->assertHasNoErrors();

    expect($this->appointment->fresh()->status)->toBe(AppointmentStatus::Cancelled);
});

test('customers can\'t cancel an already cancelled appointments', function () {
    $this->appointment->update([
        'status' => AppointmentStatus::Cancelled,
    ]);

    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee(__('Cancel appointment'))
        ->call('cancel')
        ->assertHasNoErrors();

    expect($this->appointment->fresh()->status)->toBe(AppointmentStatus::Cancelled);
});

test('customers can only cancel their own appointments', function () {
    $otherAppointment = Appointment::factory()->create();

    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $otherAppointment])
        ->assertSee(__('Cancel appointment'))
        ->call('cancel')
        ->assertForbidden();
});

test('barbers can\'t cancel their appointments', function () {
    Livewire::actingAs($this->barber)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee(__('Cancel appointment'))
        ->call('cancel')
        ->assertForbidden();

    expect($this->appointment->fresh()->status)->toBe(AppointmentStatus::Confirmed);
});
