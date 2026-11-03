<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('barbers', 'pages::barbers.index')->name('barbers.index');
    Route::livewire('appointments', 'pages::appointments.index')->name('appointments.index');
    Route::livewire('barbers/{barber}/book', 'pages::appointments.create')->name('appointments.create');
});

require __DIR__.'/settings.php';
