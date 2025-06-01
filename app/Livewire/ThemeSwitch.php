<?php

namespace App\Livewire;

use Illuminate\Support\Facades\{Cookie, Session};
use Illuminate\View\View;
use Livewire\Component;

class ThemeSwitch extends Component
{
    public string $theme = 'system';

    public function mount(): void
    {
        $this->theme = Session::get('theme', Cookie::get('theme', 'system'));
    }

    public function setTheme(string $newTheme): void
    {
        $this->theme = $newTheme;

        Session::put('theme', $newTheme);
        Cookie::queue('theme', $newTheme, 60 * 24 * 365);

        $this->dispatch('theme-changed', theme: $newTheme);
    }

    public function toggleTheme(): void
    {
        $themes       = ['light', 'dark', 'system'];
        $currentIndex = array_search($this->theme, $themes);
        $nextIndex    = ($currentIndex + 1) % count($themes);
        $this->setTheme($themes[$nextIndex]);
    }

    public function render(): View
    {
        return view('livewire.theme-switch');
    }
}
