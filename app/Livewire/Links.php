<?php

namespace App\Livewire;

use App\Models\UserLink;
use Filament\Forms\{ComponentContainer,Form};
use Filament\Forms\Components\{Select, TextInput, Toggle, View as ViewFilament};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Layout('components.layouts.app')]
#[Title('Links')]
class Links extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public ?UserLink $editingLink = null;

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

    public function table(Table $table): Table
    {
        return $table
            ->query(UserLink::query()->where('user_id', auth()->id()))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('icon')
                    ->label('Ícone')
                    ->icon(fn (UserLink $record): string => "heroicon-o-{$record->icon}")
                    ->color('primary'),
                IconColumn::make('is_active')
                    ->label('Ativo'),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('Links ativos')
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
                Filter::make('is_not_active')
                    ->label('Links não ativos')
                    ->query(fn (Builder $query) => $query->where('is_active', false)),
            ])
            ->actions([
                Action::make('edit')
                    ->icon('heroicon-m-pencil-square')
                    ->action(fn (UserLink $record) => $this->edit($record)),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-m-trash')
                    ->action(fn (UserLink $record) => $this->destroy($record)),
            ])
            ->bulkActions([
                //
            ]);
    }

    public function store(): void
    {
        auth()->user()->userLinks()->create($this->form->getState());

        $this->form->fill();
        $this->dispatch('close-modal', id: 'create-edit-link');

        Notification::make()
          ->title('Criado com sucesso!')
          ->success()
          ->send();
    }

    public function edit(UserLink $userLink): void
    {
        $this->authorize('update', $userLink);

        $this->data = $userLink->attributesToArray();
        $this->dispatch('open-modal', id: 'create-edit-link');
        $this->editingLink = $userLink;
    }

    public function update(): void
    {
        $this->authorize('update', $this->editingLink);

        $this->editingLink->update($this->form->getState());

        $this->form->fill();
        $this->editingLink = null;
        $this->dispatch('close-modal', id: 'create-edit-link');

        Notification::make()
        ->title('Atualizado com sucesso!')
        ->success()
        ->send();
    }

    public function destroy(UserLink $userLink): void
    {
        $this->authorize('delete', $this->editingLink);

        $userLink->delete();

        Notification::make()
            ->title('Deletado com sucesso!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.links');
    }
}
