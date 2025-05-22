<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');

});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('profile', fn () => 'hello profile')->name('profile'); // TODO Implementa a rota adequadamente

    Route::post('logout', App\Livewire\Actions\Logout::class)
        ->name('logout');
});
