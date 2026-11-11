<?php

use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingHour;
use App\Rules\WithinWorkingHours;
use Carbon\CarbonImmutable;
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

    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $weekday) {
        WorkingHour::factory()->create([
            'barber_id' => $this->barber->id,
            'weekday' => $weekday,
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
        ]);
    }

    $this->appointment = Appointment::factory()->create([
        'barber_id' => $this->barber->id,
        'customer_id' => $this->customer->id,
    ]);

    $this->travelTo(CarbonImmutable::parse('2026-11-09 12:00'));
    $this->date = '2026-11-11';
    $this->time = '10:00';
});

test('customers can\'t reschedule to the same date', function () {
    // TODO: Finish
    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee(__('Modify appointment'))
        ->assertHasNoErrors();
});

test('customers can\'t reschedule to a date where the barber is not working', function () {
    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee($this->appointment->date)
        ->set('form.date', '2026-11-14')
        ->set('form.time', $this->time)
        ->call('reschedule')
        ->assertHasErrors(['form.time' => WithinWorkingHours::class]);
});

test('customers can\'t reschedule to a time where the barber is not working', function () {
    Livewire::actingAs($this->customer)
        ->test('appointments.card', ['appointment' => $this->appointment])
        ->assertSee($this->appointment->date)
        ->set('form.date', $this->date)
        ->set('form.time', '18:00')
        ->call('reschedule')
        ->assertHasErrors(['form.time' => WithinWorkingHours::class]);
});
