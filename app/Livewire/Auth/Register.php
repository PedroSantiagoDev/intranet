<?php

namespace App\Livewire\Auth;

use App\Models\{Unit, User, UserLink, VisitorLinks};
use Filament\Forms\{ComponentContainer,Form};
use Filament\Forms\Components\{Select, TextInput};
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
                Select::make('unit_id')
                    ->label('Unidade')
                    ->options(
                        Unit::orderByRaw("CAST(SUBSTRING_INDEX(name, 'ª', 1) AS UNSIGNED)")
                            ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->extraAttributes(['class' => 'text-left']),
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

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        $links = VisitorLinks::all();

        if ($links->isNotEmpty()) {
            foreach ($links as $link) {
                UserLink::create([
                    'user_id'   => $user->id,
                    'name'      => $link->name,
                    'url'       => $link->url,
                    'icon'      => $link->icon,
                    'is_active' => true,
                ]);
            }
        }

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
