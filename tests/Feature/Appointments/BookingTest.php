<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingHour;
use App\Rules\MinimumTime;
use App\Rules\WithinWorkingHours;
use Carbon\CarbonImmutable;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

pest()->use(RefreshDatabase::class);

beforeEach(function () {
    // Test environment:
    // 1 barber with 1 service, works monday-friday 08:00-16:00
    // 1 customer
    // fix date: 2026-11-09 12:00

    $this->seed(RolesAndPermissionsSeeder::class);

    $this->barber = User::factory()->create()->assignRole('barber');
    $this->customer = User::factory()->create()->assignRole('customer');

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

    $this->travelTo(CarbonImmutable::parse('2026-11-09 12:00'));
    $this->date = '2026-11-11';
    $this->time = '10:00';

    $this->actingAs($this->customer);
});

test('customers can book an appointment with a barber', function () {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $this->service->id)
        ->set('form.date', $this->date)
        ->set('form.time', $this->time)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('appointments.index'));

    $appointment = Appointment::first();

    $expected = CarbonImmutable::createFromFormat('!Y-m-d H:i', "{$this->date} {$this->time}");

    expect($appointment)
        ->barber_id->toBe($this->barber->id)
        ->customer_id->toBe($this->customer->id)
        ->service_id->toBe($this->service->id)
        ->date->equalTo($expected)->tobeTrue()
        ->status->toBe(AppointmentStatus::Confirmed);
});

test('customers can book an appointment with a barber at least 2 hours before their chosen time', function (string $hour) {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $this->service->id)
        ->set('form.date', now()->format('Y-m-d'))
        ->set('form.time', $hour)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('appointments.index'));

    $appointment = Appointment::first();

    $expected = CarbonImmutable::parse("2026-11-09 {$hour}");

    expect($appointment)
        ->barber_id->toBe($this->barber->id)
        ->customer_id->toBe($this->customer->id)
        ->service_id->toBe($this->service->id)
        ->date->equalTo($expected)->toBeTrue()
        ->status->toBe(AppointmentStatus::Confirmed);
})->with([
    '2 hours' => '14:00',
    '3 hours' => '15:00',
    'last slot' => '15:30',
]);

test('customers cannot book an appointment with empty or invalid fields', function (
    string $field, string $value, string $rule
) {
    $input = [
        'serviceId' => (string) $this->service->id,
        'date' => $this->date,
        'time' => $this->time,
        $field => $value,
    ];

    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', $input['serviceId'])
        ->set('form.date', $input['date'])
        ->set('form.time', $input['time'])
        ->call('save')
        ->assertHasErrors(["form.{$field}" => $rule]);
})->with([
    'empty service' => ['serviceId', '', 'required'],
    'non-existent service' => ['serviceId', '-1', 'exists'],
    'non-existent service #2' => ['serviceId', '999', 'exists'],
    'empty date' => ['date', '', 'required'],
    'badly formatted date' => ['date', 'not-a-date', 'date_format'],
    'empty time' => ['time', '', 'required'],
    'badly formatted time' => ['time', '12:99', 'date_format'],
]);

test('customers cannot book an appointment with a barber that does not offer the selected service', function () {
    $otherService = Service::factory()->create();

    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $otherService->id)
        ->set('form.date', $this->date)
        ->set('form.time', $this->time)
        ->call('save')
        ->assertHasErrors(['form.serviceId' => 'exists']);
});

test('customers cannot book an appointment with a barber before today', function (int $days) {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $this->service->id)
        ->set('form.date', now()->subDays($days)->format('Y-m-d'))
        ->set('form.time', $this->time)
        ->call('save')
        ->assertHasErrors(['form.date' => 'after_or_equal']);
})->with([
    'yesterday' => 1,
    'last week' => 7,
    'last month' => 30,
    'last year' => 365,
]);

test('customers cannot book an appointment with a barber with less than 2 hours before their chosen time', function (int $minutes) {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $this->service->id)
        ->set('form.date', now()->format('Y-m-d'))
        ->set('form.time', now()->addMinutes($minutes)->format('H:i'))
        ->call('save')
        ->assertHasErrors(['form.time' => MinimumTime::class]);
})->with([
    'one minute short' => 119,
    'one hour' => 60,
    '1 minute' => 1,
]);

test('customers cannot book an appointment with a barber before or after the barbers working hours', function (string $hour) {
    Livewire::test('pages::appointments.create', ['barber' => $this->barber])
        ->set('form.serviceId', (string) $this->service->id)
        ->set('form.date', $this->date)
        ->set('form.time', $hour)
        ->call('save')
        ->assertHasErrors(['form.time' => WithinWorkingHours::class]);
})->with([
    'before: half hour' => '07:30',
    'before: one hour' => '07:00',
    'before: 1 minute' => '07:59',
    'after: half hour' => '16:30',
    'after: one hour' => '17:00',
    'after: one minute' => '16:01',
]);
