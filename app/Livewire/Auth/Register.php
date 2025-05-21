<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Forms\{ComponentContainer,Form};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Layout('components.layouts.auth')]
#[Title('Register')]
class Register extends Component implements HasForms
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
                TextInput::make('name')
                    ->label(__('Name'))
                    ->placeholder(__('Full name'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->placeholder('email@example.com')
                    ->required()
                    ->unique(User::class),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->placeholder(__('Password'))
                    ->required()
                    ->rules([Rules\Password::default()])
                    ->confirmed(),
                TextInput::make('password_confirmation')
                    ->label(__('Confirm password'))
                    ->password()
                    ->revealable()
                    ->placeholder(__('Confirm password'))
                    ->required(),
            ])
            ->statePath('data');
    }

    public function register(): void
    {
        $validated = $this->form->getState();

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
