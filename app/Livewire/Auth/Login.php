<?php

namespace App\Livewire\Auth;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
