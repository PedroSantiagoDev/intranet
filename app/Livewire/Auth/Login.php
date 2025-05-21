<?php

namespace App\Livewire\Auth;

use Filament\Forms\{ComponentContainer, Form};
use Filament\Forms\Components\{Checkbox, TextInput};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\{Auth, RateLimiter, Session};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Layout('components.layouts.auth')]
#[Title('Login')]
class Login extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->placeholder('email@example.com')
                    ->required(),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->placeholder(__('Password'))
                    ->required(),
                Checkbox::make('remember')
                    ->label(__('Remember me')),
            ])
            ->statePath('data');
    }

    public function login(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->data['email'], 'password' => $this->data['password']], $this->data['remember'])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->data['email']) . '|' . request()->ip());
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
