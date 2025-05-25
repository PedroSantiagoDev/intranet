<?php

namespace App\Livewire\Profile;

use Filament\Forms\{ComponentContainer, Form};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Title('Login')]
class UpdateProfile extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $this->data['name']  = Auth::user()->name;
        $this->data['email'] = Auth::user()->email;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->string()
                    ->maxLength(255)
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->placeholder('email@example.com')
                    ->rules([Rules\Password::default()])
                    ->required(),
            ])
            ->statePath('data');
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->form->getState();

        $user->fill($validated);

        $user->save();

        Notification::make()
            ->title(__('Saved.'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.profile.update-profile');
    }
}
