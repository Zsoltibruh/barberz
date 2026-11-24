<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('can:manage barbershop')->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');

        Route::livewire('opening-hours', 'pages::opening-hours.index')
            ->name('opening-hours.index');
        Route::livewire('services', 'pages::services.manage')
            ->name('services.manage');
        Route::livewire('barbers/manage', 'pages::barbers.manage')
            ->name('barbers.manage');
    });

    Route::middleware('can:set working hours')->group(function () {
        Route::livewire('working-hours', 'pages::working-hours.index')
            ->name('working-hours.index');
    });

    Route::livewire('appointments', 'pages::appointments.index')->name('appointments.index');

    Route::livewire('barbers', 'pages::barbers.index')->name('barbers.index');
    Route::livewire('barbers/{barber}/book', 'pages::appointments.create')->name('appointments.create');
});

require __DIR__.'/settings.php';
