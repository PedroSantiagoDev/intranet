<?php

namespace App\Livewire;

use Filament\Forms\{ComponentContainer,Form};
use Filament\Forms\Components\{Select, TextInput, Toggle, View as ViewFilament};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Layout('components.layouts.app')]
#[Title('Links')]
class Links extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public string $icon = 'link';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->required(),
                Select::make('icon')
                    ->label('Ícone')
                    ->required()
                    ->options(config('icons'))
                    ->searchable()
                    ->default('link')
                    ->live(),
                ViewFilament::make('livewire.partials.icon-helper')
                    ->viewData(fn () => ['icon' => $this->data['icon'] ?? 'link'])
                    ->reactive(),
                Toggle::make('is_active')
                    ->label('Ativo?')
                    ->default(true),
            ])
            ->statePath('data');
    }

    public function store(): void
    {
        auth()->user()->userLinks()->create($this->form->getState());

        Notification::make()
          ->title('Criado com sucesso!')
          ->success()
          ->send();
    }

    public function render(): View
    {
        return view('livewire.links');
    }
}
