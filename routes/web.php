<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Dashboard, Home, Links};
use App\Livewire\Reservation\{ReservationForm, ReservationTable};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('links', Links::class)->name('links');

    Route::get('reservation', ReservationTable::class)
        ->name('reservations.index');

    Route::get('reservation/create', ReservationForm::class)
        ->name('reservations.create');

    Route::get('reservation/{reservation}/edit', ReservationForm::class)
        ->name('reservations.edit')
        ->middleware('can.edit.reservation');

    Route::view('profile', 'profile')->name('profile');

    Route::post('logout', Logout::class)->name('logout');
});
