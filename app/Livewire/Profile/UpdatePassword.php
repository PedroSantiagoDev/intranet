<?php

namespace App\Livewire\Profile;

use Filament\Forms\{ComponentContainer,Form};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
class UpdatePassword extends Component implements HasForms
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
                TextInput::make('current_password')
                    ->label('Senha Atual')
                    ->password()
                    ->required()
                    ->rule('current_password'),

                TextInput::make('password')
                    ->label('Nova Senha')
                    ->password()
                    ->required()
                    ->rules([Password::defaults()])
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Confirme a Nova Senha')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function updatePassword(): void
    {
        $this->validate();

        Auth::user()->update([
            'password' => Hash::make($this->data['password']),
        ]);

        $this->form->fill();

        Notification::make()
            ->title('Senha atualizada com sucesso!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.profile.update-password');
    }
}
