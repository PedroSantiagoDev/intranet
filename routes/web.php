<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\{Dashboard, Home, Links};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');

});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('links', Links::class)->name('links');

    Route::view('profile', 'profile')->name('profile');

    Route::post('logout', App\Livewire\Actions\Logout::class)
        ->name('logout');
});
