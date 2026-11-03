<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->barber = User::factory()->create()->assignRole('barber');
    $this->customer = User::factory()->create()->assignRole('customer');

    $this->service = Service::factory()->create();
    $this->barber->barberServices()->attach($this->service);

    $this->actingAs($this->customer);
});

test('authenticated users can book an appointment with a barber', function () {
    $this->get(route('appointments.create', ['barber' => $this->barber]))
        ->assertOk();

    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', (string) $this->service->id)
        ->set('date', now()->addDay()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('appointments.index'));

    $appointment = Appointment::first();

    expect($appointment)
        ->barber_id->toBe($this->barber->id)
        ->customer_id->toBe($this->customer->id)
        ->service_id->toBe($this->service->id)
        ->status->toBe(AppointmentStatus::Confirmed);
});

test('authenticated users cannot book an appointment with an invalid service', function () {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', '-1')
        ->set('date', now()->addDay()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasErrors(['serviceId' => 'exists']);
});

test('authenticated users cannot book an appointment with an empty service', function () {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', null)
        ->set('date', now()->addDay()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasErrors(['serviceId' => 'required']);
});

test('authenticated users cannot book an appointment with an empty date', function () {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', (string) $this->service->id)
        ->set('date', null)
        ->call('save')
        ->assertHasErrors(['date' => 'required']);
});

test('authenticated users cannot book an appointment with a barber that does not offer the selected service', function () {
    $otherService = Service::factory()->create();

    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', (string) $otherService->id)
        ->set('date', now()->addDay()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasErrors(['serviceId' => 'in']);
});

test('authenticated users cannot book an appointment with a barber in the past', function () {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('serviceId', (string) $this->service->id)
        ->set('date', now()->subDay()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasErrors(['date' => 'after_or_equal:now']);
});
