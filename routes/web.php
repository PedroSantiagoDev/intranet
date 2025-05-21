<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');

});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', fn () => 'ola dashboard')->name('dashboard');

    Route::get('logout', App\Livewire\Actions\Logout::class) // TODO mudar para post
        ->name('logout');
});
